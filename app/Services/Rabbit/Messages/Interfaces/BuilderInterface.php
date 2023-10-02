<?php

namespace App\Services\Rabbit\Messages\Interfaces;

use App\Services\Rabbit\Messages\MessagesDTO;
use Closure;

interface BuilderInterface
{
    public function handle(MessagesDTO $messagesDTO, Closure $next): MessagesDTO;
}
