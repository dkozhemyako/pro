<?php

namespace App\Services\User\Handlers;

use App\Repositories\WhiteListIp\WhiteListIpRepository;
use App\Services\User\Interfaces\LoginInterface;
use App\Services\User\LoginDTO;
use Closure;

class CheckWhiteListIpHandler implements LoginInterface
{
    public function __construct
    (
        protected WhiteListIpRepository $whiteListIpRepository
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $exists = $this->whiteListIpRepository->existByUserIdByIp
        (
            $loginDTO->getUser()->getId(),
            $loginDTO->getIp(),
        );

        if ($exists === false) {
            $loginDTO->setError();
            return $loginDTO;
        }

        return $next($loginDTO);
    }
}
