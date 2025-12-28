<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        $planPurchase = Auth::user()->planPurchase()->where('status', 'Approved')->first();

        return view('panel.plans.index', [
            'plans' => $plans,
            'planPurchase' => $planPurchase
        ]);
    }

    public function signed(Plan $plan)
    {
        return view('panel.plans.signed', [
            'plan' => $plan
        ]);
    }

    public function processSigned(Plan $plan, Request $request)
    {
        if ($request->type_payment == 'card') {
           // 1. Define os dados dinâmicos que você quer recuperar depois
            $planId = '6728207e95ba42db821bfd84af1b0044';
            $externalReference = $plan->id . ',' . Auth::id(); // O dado que você já estava usando
            $payerEmail = Auth::user()->email;

            // 2. Busca o plano no Mercado Pago
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.mercadopago.com/preapproval_plan/{$planId}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . config('api.mp.access_token' ),
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE );
            curl_close($curl);

            $planDetails = json_decode($response);

            if ($httpCode === 200 && isset($planDetails->init_point )) {
                // 3. Adiciona os dados dinâmicos na URL de checkout
                // O Mercado Pago aceita 'external_reference' e 'prefilled_email' na URL
                $checkoutUrl = $planDetails->init_point . "&external_reference=" . urlencode($externalReference) . "&prefilled_email=" . urlencode($payerEmail);

                // Redireciona o usuário para o checkout já com os dados vinculados
                return redirect($checkoutUrl);
            }

            return back()->withErrors(['error' => 'Erro ao gerar link de assinatura.']);
        } else {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                  "external_reference": "' . $plan->id . ',' . Auth::id() . '",
                  "transaction_amount": ' . $plan->price . ',
                  "description": "Pagamento Plano (Loja do Insta)",
                  "payment_method_id": "pix",
                  "payer": {
                    "email": "' . Auth::user()->email . '",
                    "first_name": "' . Auth::user()->name . '"
                  },
                  "notification_url": "' . route('api.plans.notification') . '"
                }',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'content-type: application/json',
                    'Authorization: Bearer ' . config('api.mp.access_token'),
                    'X-Idempotency-Key: ' . (string) \Illuminate\Support\Str::uuid(),
                ),
            ));

            $payment = json_decode(curl_exec($curl));

            curl_close($curl);

            return response()->json([
                'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
                'qr_code' => $payment->point_of_interaction->transaction_data->qr_code
            ]);
        }
    }
}
