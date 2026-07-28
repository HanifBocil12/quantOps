<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'binance' => [
        'key' => env('BINANCE_API_KEY'),
        'secret' => env('BINANCE_API_SECRET'),
        'base_url' => env('BINANCE_BASE_URL', 'https://api.binance.com'),
        'futures_url' => env('BINANCE_FUTURES_URL'),
    ],
    'cron' => [
        'cron_secret' => env('CRON_SECRET'),
    ],
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    ],
    'telegram_proxy' => [
        'host' => env('TELEGRAM_PROXY_HOST'),
        'port' => env('TELEGRAM_PROXY_PORT'),
        'user' => env('TELEGRAM_PROXY_USER'),
        'pass' => env('TELEGRAM_PROXY_PASS'),
    ],
];
