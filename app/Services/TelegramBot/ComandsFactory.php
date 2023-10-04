<?php

namespace App\Services\TelegramBot;

use App\Enums\TelegramComandEnum;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookHandler;
use App\Services\TelegramBot\Handlers\DeleteHandler;
use App\Services\TelegramBot\Handlers\InfoHandler;
use App\Services\TelegramBot\Handlers\LoadHandler;
use App\Services\TelegramBot\Handlers\ShowHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateHandler;

class ComandsFactory
{
    public function handle(TelegramComandEnum $comandEnum): ComandsInterface
    {
        return match ($comandEnum) {
            TelegramComandEnum::INFO => app(InfoHandler::class),
            TelegramComandEnum::CREATE_BOOK => app(CreateBookHandler::class),
            TelegramComandEnum::DELETE_BOOK => app(DeleteHandler::class),
            TelegramComandEnum::UPDATE_BOOK => app(UpdateHandler::class),
            TelegramComandEnum::SHOW_BOOK => app(ShowHandler::class),
            TelegramComandEnum::LOAD_BOOK => app(LoadHandler::class),
        };
    }
}
