<?php

namespace App\Services\TelegramBot\Handlers\UpdateHandler\Handlers;


use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookTelegramDTO;
use Closure;
use Illuminate\Support\Facades\Redis;


class CheckIdHandler implements UpdateBookHandlersInterface
{

    private const KEY_NAME = 'book-update-id';
    private const NEXT_MSG = 'Enter new name for book';

    public function handle(UpdateBookTelegramDTO $updateBookTelegramDTO, Closure $next): UpdateBookTelegramDTO
    {
        $checkKey = Redis::exists($updateBookTelegramDTO->getSenderId() . self::KEY_NAME);
        if ($checkKey == false) {
            Redis::set($updateBookTelegramDTO->getSenderId() . self::KEY_NAME, $updateBookTelegramDTO->getArgument());
            $updateBookTelegramDTO->setMessage(self::NEXT_MSG);
            return $updateBookTelegramDTO;
        }

        $updateBookTelegramDTO->setId((int)Redis::get($updateBookTelegramDTO->getSenderId() . self::KEY_NAME));
        return $next($updateBookTelegramDTO);
    }
}
