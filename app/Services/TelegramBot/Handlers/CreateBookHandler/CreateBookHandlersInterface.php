<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler;

use Closure;

interface CreateBookHandlersInterface
{
    public function handle(CreateBookTelegramDTO $createBookTelegramDTO, Closure $next): CreateBookTelegramDTO;
}
