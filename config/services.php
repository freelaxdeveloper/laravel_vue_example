<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'twitch' => [
        'client_id' => env('TWITCH_CLIENT_ID'),         // Your GitHub Client ID
        'client_secret' => env('TWITCH_CLIENT_SECRET'), // Your GitHub Client Secret
        'redirect' => env('TWITCH_REDIRECT'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '1006735515237-289taqj0uc01g3qsek2vk8bl031u9546.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', '2J6vrTGXFtYKFfQgMBqe7q8Z'),
        'redirect' => env('GOOGLE_CLIENT_REDIRECT', 'https://api.donatesupp.com/oauth/google/rollback'),
    ],

    'vkontakte' => [
        'client_id' => env('VK_CLIENT_ID', 6858642),
        'client_secret' => env('VK_CLIENT_SECRET', 'CUE2xwAUQ1bn9SYh3LYt'),
        'redirect' => 'https://api.donatesupp.com/oauth/vkontakte/rollback',
    ],

];
