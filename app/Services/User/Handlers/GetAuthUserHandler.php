<?php

namespace App\Services\User\Handlers;

use App\Services\User\GetAuthUserService;
use App\Services\User\Interfaces\LoginInterface;
use App\Services\User\LoginDTO;
use Closure;

class GetAuthUserHandler implements LoginInterface
{
    public function __construct(
        protected GetAuthUserService $getAuthUserService,
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $loginDTO->setUser
        (
            $this->getAuthUserService->handle()
        );

        return $next($loginDTO);
    }
}
