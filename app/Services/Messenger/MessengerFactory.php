<?php

namespace App\Services\Messenger;

use App\Enums\MessengerEnum;
use App\Services\Messenger\SlackMessenger\SlackMessengerService;
use App\Services\Messenger\TelegramMessenger\TelegramMessengerService;

class MessengerFactory
{
    public function handle(MessengerEnum $messenger): MessengerInterface
    {
        return match($messenger){
          MessengerEnum::SLACK=>app(SlackMessengerService::class),
          MessengerEnum::TELEGRAM=>app(TelegramMessengerService::class),
        };
    }
}
