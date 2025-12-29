<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PurchaseRequest;
use App\Models\CartProduct;
use App\Models\Purchase;
use App\Models\User;
use App\Services\Web\PurchaseService;
use App\Support\MercadoPago;
use App\Support\PushinPay;
use App\Support\EvolutionApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use MercadoPago\SDK;
use MercadoPago\MerchantOrder;
use MercadoPago\Payment;
use Illuminate\Http\Request;
use App\Models\Payment as PaymentModel;

class PurchaseController extends Controller
{
    public function store(PurchaseRequest $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();

        if ($request->type == 'pix_direct') {
            $service = $user->services()->findOrFail($request->service);

            $purchase = new Purchase();
            $purchase->user_id = $user->id;
            $purchase->service_id = $service->id;
            $purchase->name = $request->name;
            $purchase->whatsapp = $request->whatsapp;
            $purchase->email = $request->email;
            $purchase->instagram = $request->link;
            $purchase->price = ($request->quantity / 100) * $service->price;
            $purchase->save();

            $payment = $user->payment()->first();
            $data = json_decode($payment->data);
            $paymentMethod = $data->payment_method ?? 'mercadopago'; // Assumindo mercadopago como default

            $pix = null;
            $qrCode = null;
            $qrCodeBase64 = null;
            $paymentId = null;

            if ($paymentMethod == 'mercadopago') {
                $pixGateway = new MercadoPago($data->access_token);
                $pixGateway->pix($payment->id, number_format($purchase->price, 2), $purchase->id, $request->email, explode(" ", $request->name)[0],
                    explode(" ", $request->name)[1] ?? "");
                $pix = $pixGateway->callback();

                if (isset($pix->point_of_interaction->transaction_data->qr_code)) {
                    $qrCode = $pix->point_of_interaction->transaction_data->qr_code;
                    $qrCodeBase64 = $pix->point_of_interaction->transaction_data->qr_code_base64;
                    $paymentId = $pix->id;
                } else {
                    dd($pix);
                }
            } elseif ($paymentMethod == 'pushinpay') {
                $pixGateway = new PushinPay($data->bearer_token, route('api.purchases.notificationTemplate', [
                    'token' => config('api.payment.token_notification'),
                    'payment_model_id' => $payment->id,
                    'external_reference' => $purchase->id,
                ]));
                $pixGateway->pix($payment->id, number_format($purchase->price, 2), $purchase->id, 'Pagamento ' . $purchase->id);
                $pix = $pixGateway->callback();

                if (isset($pix->qr_code)) {
                    $qrCode = $pix->qr_code;
                    $qrCodeBase64 = str_replace('data:image/png;base64,' ,'', $pix->qr_code_base64);
                    $paymentId = $pix->id;
                } else {
                    dd($pix);
                }
            }

            if ($paymentId) {
                Purchase::where('id', $purchase->id)->update(['payment_id' => $paymentId]);
            }

            if ($qrCode) {
                // Envio de PIX via Evolution API
                $instance = $user->whatsappInstance()->first();
                if ($instance && $instance->status === 'connected') {
                    $evolutionApi = new EvolutionApi($instance);
                    $evolutionApi->sendPix('5561993230011', $qrCode);
                }

                return response()->json([
                    'id' => $purchase->id,
                    'qr_code' => $qrCode,
                    'qr_code_base64' => $qrCodeBase64,
                    'success' => true
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Erro ao gerar PIX'
            ], 500);
        } else {
            $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
            $ipFixed = $request->ipFixed ?? $request->ip();

            $hash = md5($ipFixed . $user->domain);
            $cartProducts = CartProduct::with('service')->where('hash', $hash)->latest('id')->get();

            $sumProducts = [];
            $idsPurchase = [];
            foreach ($cartProducts as $cartProduct) {
                if ($cartProduct->service->type == 4) {
                    $count = substr_count($cartProduct->comment, "\n") + 1;
                    $sumProducts[] = $cartProduct->service->price * $count;
                } else {
                    $sumProducts[] = $cartProduct->service->price;
                }

                $purchase = new Purchase();
                $purchase->user_id = $user->id;
                $purchase->service_id = $cartProduct->service_id;
                $purchase->name = $request->name;
                $purchase->whatsapp = $request->whatsapp;
                $purchase->email = $request->email;
                $purchase->instagram = $cartProduct->link;
                $purchase->price = $cartProduct->service->price;
                $purchase->comment = $cartProduct->comment;
                $purchase->save();

                $idsPurchase[] = $purchase->id;
            }

            $serviceDescount = $user->serviceDescounts()->where('price_min', '<=', array_sum($sumProducts))
                ->latest('price_min')->first();

            $sumProductsTotal = array_sum($sumProducts);
            if (isset($serviceDescount->percent)) {
                $sumProductsTotal = array_sum($sumProducts) - (array_sum($sumProducts) / 100 * $serviceDescount->percent);

                foreach ($idsPurchase as $idPurchase) {
                    $purchase = Purchase::findOrFail($idPurchase);
                    $purchase->price = $purchase->price - ($purchase->price / 100 * $serviceDescount->percent);
                    $purchase->descount = $serviceDescount->percent;
                    $purchase->update();
                }
            }

            if (Cache::has('coupon.' . $hash)) {
                $coupon = Cache::get('coupon.' . $hash);
                $discountCoupon = $user->discountCoupons()->where('cupom', $coupon)->first();

                if ($discountCoupon) {
                    Purchase::whereIn('id', $idsPurchase)->update(['discount_coupon_id' => $discountCoupon->id]);

                    if ($discountCoupon->discount_type == 'percent') {
                        $sumProductsTotal = array_sum($sumProducts) - (array_sum($sumProducts) / 100 * $discountCoupon->percent);
                    } else {
                        $sumProductsTotal = array_sum($sumProducts) - $discountCoupon->fixed_value;
                    }
                }
            }

            $payment = $user->payment()->first();

            if ($request->type == 'pix') {
                $data = json_decode($payment->data);
                $paymentMethod = $data->payment_method ?? 'mercadopago'; // Assumindo mercadopago como default

                $pix = null;
                $qrCode = null;
                $qrCodeBase64 = null;
                $paymentId = null;

                if ($paymentMethod == 'mercadopago') {
                    $pixGateway = new MercadoPago($data->access_token);
                    $pixGateway->pix($payment->id, number_format($sumProductsTotal, 2), implode(',', $idsPurchase), $request->email, explode(" ", $request->name)[0],
                        explode(" ", $request->name)[1] ?? "");
                    $pix = $pixGateway->callback();

                    if (isset($pix->point_of_interaction->transaction_data->qr_code)) {
                        $qrCode = $pix->point_of_interaction->transaction_data->qr_code;
                        $qrCodeBase64 = $pix->point_of_interaction->transaction_data->qr_code_base64;
                        $paymentId = $pix->id;
                    } else {
                        var_dump($pix);
                        return;
                    }
                } elseif ($paymentMethod == 'pushinpay') {
                    $pixGateway = new PushinPay($data->bearer_token, route('api.purchases.notificationTemplate', [
                        'token' => config('api.payment.token_notification'),
                        'payment_model_id' => $payment->id,
                        'external_reference' => implode(',', $idsPurchase),
                    ]));
                    $pixGateway->pix($payment->id, number_format($sumProductsTotal, 2), implode(',', $idsPurchase), 'Pagamento ' . implode(',', $idsPurchase));
                    $pix = $pixGateway->callback();

                    if (isset($pix->qr_code)) {
                        $qrCode = $pix->qr_code;
                        $qrCodeBase64 = str_replace('data:image/png;base64,' ,'', $pix->qr_code_base64);
                        $paymentId = $pix->id;
                    } else {
                        var_dump($pix);
                        return;
                    }
                }

                if ($paymentId) {
                    Purchase::whereIn('id', $idsPurchase)->update(['payment_id' => $paymentId]);
                }

                if ($qrCode) {
                    if($user->id == 359){
                        $message = "🚀 Falta pouco para liberar seu pedido!\n\nSeu pedido do serviço está pronto para ser ativado.\nConfira os detalhes e confirme se está tudo certo:\n\n";
        
                        $message .= "Número do pedido: {$purchase->id}\n";
                        foreach ($cartProducts as $cartProductWhatsapp) {
                            $serviceName = $cartProductWhatsapp->service->name;
                            $quantity = $cartProductWhatsapp->service->quantity;
                            if ($cartProductWhatsapp->service->type == 4) {
                                $quantity = substr_count($cartProductWhatsapp->comment, "\n") + 1;
                            }
                            $price = $cartProductWhatsapp->price ?? $cartProductWhatsapp->service->price;
                            $totalLine = number_format($price, 2, ',', '.');
                        
                            $message .= "🎯 Serviço: {$serviceName}\n";
                            $message .= "📦 Quantidade: {$quantity}\n";
                            $message .= "💰 Valor: R$ {$totalLine}\n";
                            $message .= "---------------------------\n";
                        }
                        
                        $message .= "\nPara iniciarmos a entrega, falta apenas a confirmação do pagamento.\n";
                        $message .= "Use o código PIX abaixo para finalizar:\n\n";
                        $message .= "🔑 PIX (Copia e Cola):\n*{$qrCode}*\n\n";
                        $message .= "A liberação é imediata após a confirmação. ⚡\n";
                        $message .= "Qualquer dúvida, nossa equipe está à disposição no Whats 17-9.8145.2466\n\n";
                        $message .= "Equipe Loja do Insta 💜";
                        
                        $whatsappNumber = '55' . preg_replace('/[^0-9]/', '', $request->whatsapp);
                        
                        // Envio de PIX via Evolution API
                        $instance = $user->whatsappInstance()->first();
                        if ($instance && $instance->status === 'connected') {
                            $evolutionApi = new EvolutionApi($instance);
                            $evolutionApi->sendText($whatsappNumber, $message);
                            
                            sleep(3); 
                            
                            $evolutionApi->sendPix($whatsappNumber, $qrCode);
                        }
                    }
                    
                    return response()->json([
                        'id' => $purchase->id,
                        'qr_code' => $qrCode,
                        'qr_code_base64' => $qrCodeBase64,
                        'type' => $request->type
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao gerar PIX'
                ], 500);
            }
        }
    }

    public function notificationTemplate(Request $request)
    {
        if (config('api.payment.token_notification') != $request->token) {
            return response([
                'token' => 'Token inválido'
            ], 403);
        }

        $payment = PaymentModel::findOrFail($request->payment_model_id);
        $data = json_decode($payment->data);
        $paymentMethod = $data->payment_method ?? 'mercadopago'; // Assumindo mercadopago como default

        if ($paymentMethod == 'mercadopago') {
            SDK::setAccessToken($data->access_token);

            $merchant_order = null;
            switch ($request->topic) {
                case "payment":
                    $payment = Payment::find_by_id($request->id);
                    break;
                case "merchant_order":
                    $merchant_order = MerchantOrder::find_by_id($request->id);
                    break;
            }

            // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
            if (isset($payment->status) && $payment->status == "approved") {
                // The merchant_order has shipments
                foreach (explode(',', $payment->external_reference) as $idPurchase) {
                    $purchase = Purchase::findOrFail($idPurchase);

                    $purchaseService = new PurchaseService();
                    $purchaseService->sendOrder($purchase);

                    // Verify if the user has an active plan
                    $user = $purchase->user()->first();

                    $message = "Pagamento Aprovado 👏👏👏\n\n";
                    $message .= "Seu pedido já será enviado, se em 24 horas ele não chegar, envie o número do pedido para o Whats de atendimento 17-9.8145.2466\n\n";
                    $message .= "Equipe Loja do Insta 💜";
                    
                    // Envio de mensagem de aprovação via Evolution API
                    $instance = $purchase->user()->first()->whatsappInstance()->first();
                    if ($instance && $instance->status === 'connected') {
                        $whatsappNumber = '55' . preg_replace('/[^0-9]/', '', $purchase->whatsapp); 
                        
                        $evolutionApi = new EvolutionApi($instance);
                        $evolutionApi->sendText($whatsappNumber, $message);
                    }
                }

                return response([
                    'status' => 'success'
                ]);
            } else {
                $return = "Not paid yet. Do not release your item.";
            }
        } elseif ($paymentMethod == 'pushinpay') {
            $data = request()->all();

            if (empty($data['id']) || empty($data['status'])) {
                return response()->json(['error' => 'Dados inválidos.'], 400);
            }
    
            if($data['status'] != 'paid'){
                exit;
            }

            // The merchant_order has shipments
            foreach (explode(',', $request->query('external_reference')) as $idPurchase) {
                $purchase = Purchase::findOrFail($idPurchase);

                $purchaseService = new PurchaseService();
                $purchaseService->sendOrder($purchase);

                // Verify if the user has an active plan
                $user = $purchase->user()->first();

                $message = "Pagamento Aprovado 👏👏👏\n\n";
                $message .= "Seu pedido já será enviado, se em 24 horas ele não chegar, envie o número do pedido para o Whats de atendimento 17-9.8145.2466\n\n";
                $message .= "Equipe Loja do Insta 💜";
                
                // Envio de mensagem de aprovação via Evolution API
                $instance = $purchase->user()->first()->whatsappInstance()->first();
                if ($instance && $instance->status === 'connected') {
                    $whatsappNumber = '55' . preg_replace('/[^0-9]/', '', $purchase->whatsapp); 
                    
                    $evolutionApi = new EvolutionApi($instance);
                    $evolutionApi->sendText($whatsappNumber, $message);
                }
            }

            return response([
                'status' => 'success'
            ]);
        }
    }

    public function pushinpayWebhook(Request $request)
    {
        $payment = PaymentModel::where('payment_method_id', 'pushinpay')->first();
        
        if (!$payment) {
            return response([
                'message' => 'Gateway PushinPay não configurado'
            ], 404);
        }

        $data = json_decode($payment->data);
        
        $pushinpay = new PushinPay($data->bearer_token, route('api.webhooks.pushinpay'));
        
        if ($pushinpay->handleWebhook($request->all())) {
            return response([
                'status' => 'success'
            ]);
        }

        return response([
            'status' => 'error'
        ], 500);
    }

    public function status(Request $request)
    {
        $purchase = Purchase::findOrFail($request->id);
        $user = $purchase->user()->first();
        $conversionTag = $user->conversionTag()->first();

        return response()->json([
            'status' => $purchase->status,
            'id' => $purchase->id,
            'price' => $purchase->price,
            'code_event_ads' => ($conversionTag->code_event_ads ?? null),
        ]);
    }
}
