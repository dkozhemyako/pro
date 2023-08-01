<?php

namespace App\Services\User\Handlers;

use App\Services\User\Interfaces\LoginInterface;
use App\Services\User\LoginDTO;
use App\Services\User\LoginService;
use Closure;

class CheckLoginDataHandler implements LoginInterface
{
    public function __construct
    (
        protected LoginService $loginService
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $data = [
            'email' => $loginDTO->getEmail(),
            'password' => $loginDTO->getPassword(),
        ];
        if ($this->loginService->handle($data) === false) {
            $loginDTO->setError();
            return $loginDTO;
        }

        return $next($loginDTO);
    }
}
