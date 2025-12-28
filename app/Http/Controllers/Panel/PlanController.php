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
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.mercadopago.com/preapproval_plan/6728207e95ba42db821bfd84af1b0044',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . config('api.mp.access_token'),
                    'Accept: application/json',
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            $plan = json_decode($response);
            dd($plan);

            // Redirecionar o usuário para:
            return redirect($callback->init_point);
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
