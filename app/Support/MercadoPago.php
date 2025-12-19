<?php

namespace App\Support;

class MercadoPago
{
    private $token;
    private $data;
    private $callback;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function pix(int $paymentId, float $price, string $ids, string $email, string $name, string $lastName = null): MercadoPago
    {
        $this->data = [
            'transaction_amount' => $price,
            'notification_url' => route('api.purchases.notificationTemplate', [
                'token' => config('api.payment.token_notification'),
                'payment_model_id' => $paymentId
            ]),
            'description' => 'Pagamento ' . $ids . ' (' . config('app.name') . ')',
            'payment_method_id' => 'pix',
            'external_reference' => $ids,
            'payer' => [
                'email' => $email,
                'first_name' => $name,
                'last_name' => $lastName
            ]
        ];

        $this->post();
        return $this;
    }

    public function post()
    {
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
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer ' . $this->token,
                'X-Idempotency-Key: '. uniqid()
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $this->callback = json_decode($response);
    }

    public function callback()
    {
        return $this->callback;
    }
}
