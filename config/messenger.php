<?php

return [
    'slack' => [
        'url' => env('LOG_SLACK_WEBHOOK_URL', null),
    ],
    'telegram' => [
        'url' =>'https://api.telegram.org/bot'. env('TELEGRAM_TOKEN', null) . '/sendMessage',
        'chat_id' => env('TELEGRAM_CHAT_ID', null),
        'token' => env('TELEGRAM_TOKEN', null),
    ],
];

