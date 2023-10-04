<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers;

use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookTelegramDTO;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckCategoryIdHandler implements CreateBookHandlersInterface
{
    public function handle(CreateBookTelegramDTO $createBookTelegramDTO, Closure $next): CreateBookTelegramDTO
    {
        $createBookTelegramDTO->setCategoryId($createBookTelegramDTO->getArgument());
        return $next($createBookTelegramDTO);
    }
}
