<?php

namespace App\Support;

use App\Models\Plan;
use App\Models\PlanPurchase;
use MercadoPago\Customer;
use MercadoPago\Payer;
use MercadoPago\Payment as PaymentSdk;
use MercadoPago\SDK;

class Payment
{
    private $url;
    private $email;
    private $token;
    private $userId;
    private $callback;

    public function __construct()
    {
        $this->url = 'https://api.mercadopago.com/preapproval';
        SDK::setAccessToken(config('api.payment.token'));
    }

    public function plan(string $email, string $token, int $userId): Payment
    {
        $this->email = $email;
        $this->token = $token;
        $this->userId = $userId;

        $this->post();
        return $this;
    }

    public function customer(string $email, string $name, string $phone, string $type, string $document, int $userId): Payment
    {
        $customer = new Customer();
        $customer->email = $email;
        $customer->first_name = explode(' ', $name)[0];
        $customer->last_name = explode(' ', $name)[1] ?? '';
        $customer->phone = array(
            "area_code" => substr(clearString($phone), 0, 2),
            "number" => substr(clearString($phone), 2)
        );
        $customer->identification = array("type" => $type, "number" => $document);
        $customer->description = 'ID do usuário: ' . $userId;
        $customer->save();

        $this->callback = $customer;

        return $this;
    }

    public function card($request, Plan $plan, PlanPurchase $planPurchase, string $name, string $email): Payment
    {
        // Create Payment
        $payment = new PaymentSdk();
        $payment->transaction_amount = (float)$plan->price;
        $payment->token = $request->token;
        $payment->description = 'Pagamento do Plano';
        $payment->installments = 1;
        $payment->payment_method_id = $request->payment_method_id;
        $payment->issuer_id = (int)$request->issuer_id;
        $payment->external_reference = $planPurchase->id;
        #$payment->notification_url = route('api.reserves.notification', ['key' => 'a86d504537fb08632f422dd9d35ddbeac024816z']);

        // Create Player
        $payer = new Payer();
        $payer->email = $email;
        $payer->identification = array(
            "type" => $request->payer['identification']['type'],
            "number" => $request->payer['identification']['number']
        );
        $payer->first_name = $name;
        $payment->payer = $payer;

        $payment->save();

        // Update Status
        $planPurchase->status = ($payment->status == null ? 'rejected' : $payment->status);
        $planPurchase->update();

        $this->callback = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );

        return $this;
    }

    public function pix($request, Plan $plan, PlanPurchase $planPurchase, string $email): Payment
    {
        $payment = new PaymentSdk();
        $payment->transaction_amount = (float)$plan->price;
        $payment->description = "Pagamento do Plano";
        $payment->payment_method_id = "pix";
        $payment->external_reference = $planPurchase->id;
        #$payment->notification_url = route('api.reserves.notification', ['key' => 'a86d504537fb08632f422dd9d35ddbeac024816z']);
        $payment->payer = array(
            "email" => $email,
            "first_name" => explode(' ', $request->name)[0],
            "last_name" => explode(' ', $request->name)[1] ?? '',
            "identification" => array(
                "type" => "CPF",
                "number" => $request->document
            )
        );

        $payment->save();

        $this->callback = array(
            'qr_code_base64' => $payment->point_of_interaction->transaction_data->qr_code_base64,
            'qr_code' => $payment->point_of_interaction->transaction_data->qr_code
        );

        return $this;
    }

    private function post()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
               "preapproval_plan_id":"' . config('api.payment.plan_id') . '",
               "card_token_id":"' . $this->token . '",
               "payer_email":"' . $this->email . '",
               "external_reference":"' . $this->userId . '"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . config('api.payment.token')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);

        $this->callback = $response;
    }

    public function callback()
    {
        return $this->callback;
    }
}
