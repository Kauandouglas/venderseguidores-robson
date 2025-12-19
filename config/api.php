<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | This is where all system API settings will be.
    |
    |
    */

    'mp' => [
        'access_token' => env('API_MP_ACCESS_TOKEN'),
        'token_notification' => env('API_MP_TOKEN_NOTIFICATION')
    ],
    'key_rapidApi' => env('KEY_RAPID_API'),
    'payment' => [
        'token' => env('API_PAYMENT_TOKEN'),
        'token_notification' => env('API_PAYMENT_TOKEN_NOTIFICATION')
    ]
];
