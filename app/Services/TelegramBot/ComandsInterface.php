<?php

namespace App\Services\TelegramBot;

interface ComandsInterface
{
    public function handle(string $arguments, int $senderId): string;
}
