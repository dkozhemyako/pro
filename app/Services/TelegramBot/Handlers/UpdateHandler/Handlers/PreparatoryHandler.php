<?php

namespace App\Services\TelegramBot\Handlers\UpdateHandler\Handlers;


use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookTelegramDTO;
use Closure;
use Illuminate\Support\Facades\Redis;


class PreparatoryHandler implements UpdateBookHandlersInterface
{
    private const NEXT_MSG = 'Enter book id for update';

    public function handle(UpdateBookTelegramDTO $updateBookTelegramDTO, Closure $next): UpdateBookTelegramDTO
    {
        if ($updateBookTelegramDTO->getArgument()[0] === '/') /* if it`s command from telegram */ {
            Redis::del(
                $updateBookTelegramDTO->getSenderId() . 'book-update-id',
                $updateBookTelegramDTO->getSenderId() . 'book-update-name',
                $updateBookTelegramDTO->getSenderId() . 'book-update-year',
                $updateBookTelegramDTO->getSenderId() . 'book-update-lang',
            );
            $updateBookTelegramDTO->setMessage(self::NEXT_MSG);
            return $updateBookTelegramDTO;
        }

        return $next($updateBookTelegramDTO);
    }
}
