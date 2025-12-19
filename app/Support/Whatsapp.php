<?php

namespace App\Support;

class Whatsapp
{
    private $apiUrl;
    private $data;
    private $method;
    private $apiKey;
    private $endpoint;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = 'https://api.w-api.app/v1/';
        $this->apiKey = 'mt3ZkTkeWbMWZeJE6BiDjvbcmFWUmFiNs';
    }

    public function sendMessage(string $number, string $message): Whatsapp
    {
        $this->endpoint = "message/send-text?instanceId=CX6TXJ-54FFBY-VCBIBA";
        $this->data = [
            "phone" => $number,
            "message" => $message
        ];
        $this->method = 'POST';

        $this->post();
        return $this;
    }
    
    public function sendPix(string $number, string $pix): Whatsapp
    {
        $this->endpoint = "message/send-button-pix?instanceId=CX6TXJ-54FFBY-VCBIBA";
        $this->data = [
            "phone" => $number,
            "merchantName" => "Copie o PIX",
            "pixKey" => $pix,
            "type" => "EVP"
        ];
        $this->method = 'POST';

        $this->post();
        return $this;
    }

    private function post()
    {
        $url = $this->apiUrl . $this->endpoint;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->apiKey}",
                "Content-Type: application/json"
            ],
        ]);

        $result = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            $this->callback = json_decode("cURL Error #:" . $err);
        } else {
            $this->callback = json_decode($result);
        }
    }

    public function callback()
    {
        return $this->callback;
    }
}
