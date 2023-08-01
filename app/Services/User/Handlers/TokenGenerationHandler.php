<?php

namespace App\Services\User\Handlers;

use App\Services\User\CreateTokenUserService;
use App\Services\User\Interfaces\LoginInterface;
use App\Services\User\LoginDTO;
use Closure;

class TokenGenerationHandler implements LoginInterface
{

    public function __construct
    (
        protected CreateTokenUserService $createTokenUserService
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $loginDTO->setToken
        (
            $this->createTokenUserService->handle()
        );

        return $next($loginDTO);
    }
}
