<?php

namespace App\Services\TelegramBot\Handlers\UpdateHandler;

use Closure;

interface UpdateBookHandlersInterface
{
    public function handle(UpdateBookTelegramDTO $updateBookTelegramDTO, Closure $next): UpdateBookTelegramDTO;
}
