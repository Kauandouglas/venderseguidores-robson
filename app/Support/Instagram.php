<?php

namespace App\Support;

class Instagram
{
    private $apiUrl;
    private $apiKey;
    private $endpoint;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = 'https://instagram-scraper-2022.p.rapidapi.com/';
        $this->apiKey = config('api.key_rapidApi');
    }

    public function accountInfo(string $profile): Instagram
    {
        $this->endpoint = "ig/info_username/?user=$profile";

        $this->post();
        return $this;
    }

    public function mediaInfo(string $shortCode): Instagram
    {
        $this->endpoint = "media_info?short_code=$shortCode";

        $this->post();
        return $this;
    }

    public function stories(int $id): Instagram
    {
        $this->endpoint = "stories?user_id=$id";

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
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: instagram-scraper-2022.p.rapidapi.com",
                "x-rapidapi-key: {$this->apiKey}"
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
