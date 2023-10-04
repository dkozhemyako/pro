<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers;

use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookTelegramDTO;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckYearHandler implements CreateBookHandlersInterface
{
    private const KEY_NAME = 'book-year';
    private const NEXT_MSG = 'Enter lang';

    public function handle(CreateBookTelegramDTO $createBookTelegramDTO, Closure $next): CreateBookTelegramDTO
    {
        $checkKey = Redis::exists($createBookTelegramDTO->getSenderId() . self::KEY_NAME);
        if ($checkKey == false) {
            Redis::set($createBookTelegramDTO->getSenderId() . self::KEY_NAME, $createBookTelegramDTO->getArgument());
            $createBookTelegramDTO->setMessage(self::NEXT_MSG);
            return $createBookTelegramDTO;
        }

        $createBookTelegramDTO->setYear(Redis::get($createBookTelegramDTO->getSenderId() . self::KEY_NAME));
        return $next($createBookTelegramDTO);
    }
}
