<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartProduct;
use App\Models\Purchase;
use App\Models\User;
use App\Support\PagHiper;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;

class SystemSettingController extends Controller
{
    public function addCart(Request $request)
    {
        $user = User::users()->where('domain', $request->domain)->firstOrFail();
        $service = $user->services()->active()->findOrFail($request->service);

        $userAgentFixed = $request->userAgentFixed ?? $request->userAgent();
        $ipFixed = $request->ipFixed ?? $request->ip();

        $hash = md5($ipFixed . $user->domain);

        $cartProduct = new CartProduct();
        $cartProduct->service_id = $service->id;
        $cartProduct->hash = $hash;
        $cartProduct->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $user = User::users()->findOrFail($request->user);
        $service = $user->services()->active()->findOrFail($request->service);

        $purchase = new Purchase();
        $purchase->user_id = $user->id;
        $purchase->service_id = $service->id;
        $purchase->name = $request->name;
        $purchase->whatsapp = $request->whatsapp;
        $purchase->email = $request->email;
        $purchase->instagram = ($request->type != 3 ? clearUrlProfile($request->instagram) : $request->instagram);
        $purchase->price = ($service->type == 4 ? count(preg_split('/\r\n|\r|\n/', trim($request->comment))) * $service->price : $service->price);
        $purchase->comment = trim($request->comment);
        $purchase->save();

        $payment = $user->payment()->firstOrFail();

        if ($payment->payment_method_id == 1) {
            return response()->json([
                'url' => $this->paymentMp($purchase, $payment)
            ]);
        } else {
            $pix = $this->paymentPagHiper($purchase, $payment, $request);
            return response()->json([
                'pix_image' => $pix['pix_create_request']['pix_code']['qrcode_image_url'],
                'pix_code' => $pix['pix_create_request']['pix_code']['emv'],
            ]);
        }
    }

    private function paymentMp($purchase, $payment)
    {
        SDK::setAccessToken($payment->access_token); // Either Production or SandBox AccessToken
        $preference = new Preference();
        $item = new Item();
        $item->title = "Compra #{$purchase->id}";
        $item->quantity = 1;
        $item->unit_price = $purchase->price;
        $preference->items = array($item);
        $preference->external_reference = $purchase->id;
        $preference->back_urls = array(
            "success" => route('web.systemSettings.template', ['user' => $purchase->user_id, 'status' => 'success']),
            "failure" => route('web.systemSettings.template', ['user' => $purchase->user_id, 'status' => 'failure']),
            "pending" => route('web.systemSettings.template', ['user' => $purchase->user_id, 'status' => 'pending'])
        );
        $preference->auto_return = "approved";
        $preference->notification_url = route('api.purchases.notificationTemplate', [
            'token' => config('api.payment.token_notification'),
            'payment_model_id' => $payment->id
        ]);
        $preference->save();

        return $preference->init_point;
    }

    private function paymentPagHiper($purchase, $payment, $request)
    {
        $notifcationUrl = route('api.purchases.notificationTemplate', [
            'token' => config('api.payment.token_notification'),
            'payment_model_id' => $payment->id
        ]);

        $pagHiper = new PagHiper($payment->key_paghiper, $notifcationUrl);
        $pagHiper->proccess($purchase->id, $purchase->email, clearString($request->document), $purchase->name,
            clearString($purchase->whatsapp), "Compra #{$purchase->id}", $purchase->service_id,
            $purchase->price * 100);
        return $pagHiper->callback();
    }
}
