<?php

namespace App\Services\Messenger\TelegramMessenger;

use App\Services\Messenger\MessengerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TelegramMessengerService implements MessengerInterface
{
    public function __construct(
        protected Client $client,
    ){}

    /**
     * @throws GuzzleException
     */
    public function send($message, int $chatId = null): bool
    {
        if (is_null($chatId)){
            $chatId = config('messenger.telegram.chat_id');
        }
        $this->client->post(config('messenger.telegram.url'),
            [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $message,
                ],
            ]);

        return true;
    }
}
