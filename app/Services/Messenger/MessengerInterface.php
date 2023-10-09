<?php

namespace App\Services\Messenger;

interface MessengerInterface
{
    public function send($message, int $chatId) : bool;
}
