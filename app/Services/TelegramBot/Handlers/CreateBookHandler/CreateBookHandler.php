<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler;

use App\Services\TelegramBot\ComandsInterface;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\CheckCategoryIdHandler;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\CheckLangHandler;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\CheckNameHandler;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\CheckPagesHandler;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\CheckYearHandler;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\PreparatoryHandler;
use App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers\RepositoryHandler;
use Illuminate\Pipeline\Pipeline;

class CreateBookHandler implements ComandsInterface
{

    public const HANDLERS = [
        PreparatoryHandler::class,
        CheckNameHandler::class,
        CheckYearHandler::class,
        CheckLangHandler::class,
        CheckPagesHandler::class,
        CheckCategoryIdHandler::class,
        RepositoryHandler::class,
    ];


    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(string $arguments, int $senderId): string
    {
        $dto = new CreateBookTelegramDTO($arguments, $senderId);

        $result = $this->pipeline
            ->send($dto)
            ->through(self::HANDLERS)
            ->thenReturn();

        return $result->getMessage();
    }
}
