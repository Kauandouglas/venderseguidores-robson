<?php

namespace App\Support;

class PagHiper
{
    private $url;
    private $data;
    private $key;
    private $notificationUrl;
    private $callback;

    public function __construct(string $key, string $notificationUrl = null)
    {
        $this->url = 'https://pix.paghiper.com/invoice/create/';
        $this->key = $key;
        $this->notificationUrl = $notificationUrl;
    }

    public function proccess(int $orderId, string $email, string $document, string $name, int $phone, string $title, int $itemId, int $price): PagHiper
    {
        $this->data = [
            'apiKey' => $this->key,
            'order_id' => $orderId,
            'payer_email' => $email,
            'payer_name' => $name,
            'payer_phone' => $phone,
            'payer_cpf_cnpj' => $document,
            'notification_url' => $this->notificationUrl,
            'days_due_date' => '1',
            'items' => array(
                array('description' => $title,
                    'quantity' => '1',
                    'item_id' => $itemId,
                    'price_cents' => $price), // em centavos
            ),
        ];

        $this->post();
        return $this;
    }

    public function notification(string $transactionId, string $notificationId, string $token, string $apiKey): PagHiper
    {
        $this->url = "https://pix.paghiper.com/invoice/notification/";
        $this->data = [
            "token" => $token,
            'apiKey' => $apiKey,
            'transaction_id' => $transactionId,
            'notification_id' => $notificationId,
        ];

        $this->post();
        return $this;
    }

    private function post()
    {
        $data_post = json_encode($this->data);
        $url = $this->url;
        $mediaType = "application/json";
        $charSet = "UTF-8";
        $headers = array();
        $headers[] = "Accept: " . $mediaType;
        $headers[] = "Accept-Charset: " . $charSet;
        $headers[] = "Accept-Encoding: " . $mediaType;
        $headers[] = "Content-Type: " . $mediaType . ";charset=" . $charSet;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $response = json_decode($result, true);

        $this->callback = $response;
    }

    public function callback()
    {
        return $this->callback;
    }
}
