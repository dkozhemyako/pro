<?php

namespace App\Services\TelegramBot;

use App\Enums\TelegramComandEnum;
use App\Services\Messenger\TelegramMessenger\TelegramMessengerService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Redis;

class TelegramInboundService
{

    public function __construct(
        protected TelegramMessengerService $messengerService,
        protected ComandsFactory $comandsFactory,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function handle(InboundDTO $data)
    {
        $command = TelegramComandEnum::tryFrom($data->getMessage());

        if (is_null($command)) {
            $command = TelegramComandEnum::tryFrom(Redis::get('lastCommand' . $data->getSenderId()));
        }

        if (is_null($command)) {
            $command = TelegramComandEnum::from('/info');
        }

        Redis::set('lastCommand' . $data->getSenderId(), $command->value);

        $service = $this->comandsFactory->handle($command);
        $this->messengerService->send(
            $service->handle($data->getMessage(), $data->getSenderId()),
            $data->getSenderId(),
        );
    }
}
