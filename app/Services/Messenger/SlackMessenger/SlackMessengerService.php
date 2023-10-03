<?php

namespace App\Services\Messenger\SlackMessenger;

use App\Services\Messenger\MessengerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SlackMessengerService implements MessengerInterface
{
    public function __construct(
        protected Client $client,
    ){}

    /**
     * @throws GuzzleException
     */
    public function send($message): bool
    {
        $this->client->post(config('messenger.slack.url'),
        [
            'json' => [
                'text' => $message,
            ],
        ]);

        return true;
    }
}
