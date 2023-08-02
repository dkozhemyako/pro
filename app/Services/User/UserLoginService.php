<?php

namespace App\Services\User;

use App\Services\User\Handlers\CheckLoginDataHandler;
use App\Services\User\Handlers\CheckWhiteListIpHandler;
use App\Services\User\Handlers\GetAuthUserHandler;
use App\Services\User\Handlers\RecordingLastIpHandler;
use App\Services\User\Handlers\TokenGenerationHandler;
use Illuminate\Pipeline\Pipeline;

class UserLoginService
{
    protected const HANDLERS = [
        CheckLoginDataHandler::class,
        GetAuthUserHandler::class,
        CheckWhiteListIpHandler::class,
        TokenGenerationHandler::class,
        RecordingLastIpHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(LoginDTO $loginDTO): LoginDTO
    {
        return $this->pipeline
            ->send($loginDTO)
            ->through(self::HANDLERS)
            ->then(function (LoginDTO $loginDTO) {
                return $loginDTO;
            });
    }

}
