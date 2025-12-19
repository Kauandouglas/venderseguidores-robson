<?php

namespace App\Support;

class Expay
{
    private $url;
    private $merchantKey;
    private $data;
    private $callback;

    public function __construct()
    {
        $this->merchantKey = '$merchantKey';
    }

    public function pix(): Expay
    {
        $this->url = 'https://expaybrasil.com/en/purchase/link';
        $this->data = [
            'merchant_key' => $this->merchantKey,
            'currency_code' => 'BRL',
            'invoice' => [ "invoice_id" => "1000",
                "invoice_description" => "Descrição fatura",
                "total" => 40,
                "devedor" => "João Guedes",
                "email" => "joaoguedes@gmail.com",
                "cpf_cnpj" => "64597420061",
                "notification_url" => "https://meusite.com/notification/",
                "items" => [
                    [
                        "name" => "name",
                        "price" => "10.00",
                        "description" => "description",
                        "qty" => 1
                    ]
                ]]
        ];

        $this->post();
        return $this;
    }

    public function post()
    {
        $data = http_build_query($this->data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'content-type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Erro no cURL: ' . curl_error($ch);
        }
        curl_close($ch);

        $this->callback = json_decode($response);
    }

    public function callback()
    {
        return $this->callback;
    }
}
