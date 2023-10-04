<?php

namespace App\Services\TelegramBot\Handlers;

use App\Enums\TelegramComandEnum;
use App\Services\TelegramBot\ComandsInterface;

class InfoHandler implements ComandsInterface
{
    public function handle(string $arguments, int $senderId): string
    {
        $result = 'Make a choice: ' . PHP_EOL;
        foreach (TelegramComandEnum::cases() as $comandEnum) {
            $result .= $comandEnum->value . PHP_EOL;
        }
        return $result;
    }
}
