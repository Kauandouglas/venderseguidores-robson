<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\PlanPurchase;
use App\Models\User;
use Illuminate\Http\Request;
use MercadoPago\SDK;

class PlanController extends Controller
{
    public function notification(Request $request)
    {
        if (isset($request['data']['id'])) {
            SDK::setAccessToken(config('api.mp.access_token'));
            $payment = \MercadoPago\Payment::find_by_id($request['data']['id']);

            if (isset($payment->status) && $payment->status == "approved") {
                $plan = explode(',', $payment->external_reference)[0];
                $user = explode(',', $payment->external_reference)[1];

                $plan = Plan::find($plan);

                $planPurchaseFirst = PlanPurchase::where('user_id', $user)->first();
                if ($planPurchaseFirst) {
                    if(Invoice::where('user_id', $user)->where('status', 'Pending')->count() == 1) {
                        $planPurchaseFirst->next_payment_at = date("Y-m-d H:i:s", strtotime($planPurchaseFirst->next_payment_at . " +1 month"));
                        $planPurchaseFirst->next_cancel_at = date("Y-m-d H:i:s", strtotime($planPurchaseFirst->next_cancel_at . " +1 month"));
                        $planPurchaseFirst->next_generate_invoice_at = date("Y-m-d H:i:s", strtotime($planPurchaseFirst->next_generate_invoice_at . " +1 month"));
                        $planPurchaseFirst->status = 'Approved';
                        $planPurchaseFirst->update();
                    }

                    if($plan->id != $planPurchaseFirst->plan_id){
                        $planPurchaseFirst->next_payment_at = now()->addMonths();
                        $planPurchaseFirst->next_cancel_at = now()->addMonths()->addDays(3);
                        $planPurchaseFirst->next_generate_invoice_at = now()->addDays(20);
                        $planPurchaseFirst->plan_id = $plan->id;
                        $planPurchaseFirst->update();
                    }

                    $invoice = Invoice::where('user_id', $user)->first();
                    $invoice->status = 'Approved';
                    $invoice->update();
                } else {
                    $planPurchase = new PlanPurchase();
                    $planPurchase->user_id = $user;
                    $planPurchase->plan_id = $plan->id;
                    $planPurchase->next_payment_at = now()->addMonths();
                    $planPurchase->next_cancel_at = now()->addMonths()->addDays(3);
                    $planPurchase->next_generate_invoice_at = now()->addDays(20);
                    $planPurchase->status = 'Approved';
                    $planPurchase->save();

                    $invoice = new Invoice();
                    $invoice->user_id = $user;
                    $invoice->plan_purchase_id = $planPurchase->id;
                    $invoice->status = 'Approved';
                    $invoice->save();
                }

                $user = User::find($user);
                $whatsapp = new \App\Support\Whatsapp();
                $whatsapp->sendMessage($user->phone, "Seu plano foi ativado com sucesso! 👏👏👏

Agora você pode desfrutar de todos os benefícios do plano *{$plan->name}*.

Qualquer dúvida, estamos à disposição! 😉

Salve nosso número para receber dicas e novidades sobre vendas online. 📲📲

Caso precise de atendimento o nosso número do Whatsapp é esse: +55 17 98145-2466
");
            }
        }
    }
}
