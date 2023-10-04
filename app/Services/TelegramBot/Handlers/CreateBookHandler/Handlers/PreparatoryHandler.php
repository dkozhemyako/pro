<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers;

use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookTelegramDTO;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class PreparatoryHandler implements CreateBookHandlersInterface
{
    private const NEXT_MSG = 'Enter book name';

    public function handle(CreateBookTelegramDTO $createBookTelegramDTO, Closure $next): CreateBookTelegramDTO
    {
        if ($createBookTelegramDTO->getArgument()[0] === '/') /* if it`s command from telegram */ {
            Redis::del(
                $createBookTelegramDTO->getSenderId() . 'book-name',
                $createBookTelegramDTO->getSenderId() . 'book-year',
                $createBookTelegramDTO->getSenderId() . 'book-lang',
                $createBookTelegramDTO->getSenderId() . 'book-pages',
            );
            $createBookTelegramDTO->setMessage(self::NEXT_MSG);
            return $createBookTelegramDTO;
        }

        return $next($createBookTelegramDTO);
    }
}
