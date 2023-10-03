<?php

namespace App\Services\Messenger\TelegramMessenger;

use App\Services\Messenger\MessengerInterface;
use GuzzleHttp\Client;

class TelegramMessengerService implements MessengerInterface
{
    public function __construct(
        protected Client $client,
    ){}
    public function send($message): bool
    {
        $this->client->post(config('messenger.telegram.url'),
            [
                'json' => [
                    'chat_id' => config('messenger.telegram.chat_id'),
                    'text' => $message,
                ],
            ]);

        return true;
    }
}
