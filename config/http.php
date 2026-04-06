<?php

return [
    /*
    |--------------------------------------------------------------------------
    | HTTP Client Configuration
    |--------------------------------------------------------------------------
    |
    | Configure default settings for Laravel's HTTP client (Guzzle).
    | Useful for server environments with strict firewall/proxy rules.
    |
    */

    'defaults' => [
        'timeout' => env('HTTP_TIMEOUT', 120),
        'connect_timeout' => env('HTTP_CONNECT_TIMEOUT', 60),
        'verify' => env('HTTP_VERIFY_SSL', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Bunny.net Specific Settings
    |--------------------------------------------------------------------------
    */
    'bunny' => [
        'timeout' => env('BUNNY_TIMEOUT', 120),
        'connect_timeout' => env('BUNNY_CONNECT_TIMEOUT', 60),
        'retry_times' => env('BUNNY_RETRY_TIMES', 3),
        'retry_delay' => env('BUNNY_RETRY_DELAY', 1000), // milliseconds
    ],

    /*
    |--------------------------------------------------------------------------
    | WebXPay Specific Settings
    |--------------------------------------------------------------------------
    */
    'webxpay' => [
        'timeout' => env('WEBXPAY_TIMEOUT', 120),
        'connect_timeout' => env('WEBXPAY_CONNECT_TIMEOUT', 60),
    ],
];
