<?php

namespace App\Services\TelegramBot\Handlers\UpdateHandler\Handlers;


use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookTelegramDTO;
use Closure;

class CheckPagesHandler implements UpdateBookHandlersInterface
{
    public function handle(UpdateBookTelegramDTO $updateBookTelegramDTO, Closure $next): UpdateBookTelegramDTO
    {
        $updateBookTelegramDTO->setPages($updateBookTelegramDTO->getArgument());
        return $next($updateBookTelegramDTO);
    }
}
