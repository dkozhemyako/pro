<?php

namespace App\Services\TelegramBot\Handlers\UpdateHandler;

use App\Services\TelegramBot\ComandsInterface;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\CheckIdHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\CheckLangHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\CheckNameHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\CheckPagesHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\CheckYearHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\PreparatoryHandler;
use App\Services\TelegramBot\Handlers\UpdateHandler\Handlers\RepositoryHandler;
use Illuminate\Pipeline\Pipeline;


class UpdateHandler implements ComandsInterface
{
    public const HANDLERS = [
        PreparatoryHandler::class,
        CheckIdHandler::class,
        CheckNameHandler::class,
        CheckYearHandler::class,
        CheckLangHandler::class,
        CheckPagesHandler::class,
        RepositoryHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(string $arguments, int $senderId): string
    {
        $dto = new UpdateBookTelegramDTO($arguments, $senderId);

        $result = $this->pipeline
            ->send($dto)
            ->through(self::HANDLERS)
            ->thenReturn();

        return $result->getMessage();
    }
}
