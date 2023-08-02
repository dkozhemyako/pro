<?php

namespace App\Services\User\Handlers;

use App\Repositories\LastListIp\LastListIpRepository;
use App\Services\User\Interfaces\LoginInterface;
use App\Services\User\LoginDTO;
use Closure;

class RecordingLastIpHandler implements LoginInterface
{

    public function __construct(
        protected LastListIpRepository $lastListIpRepository,
    ) {
    }

    public function handle(LoginDTO $loginDTO, Closure $next): LoginDTO
    {
        $this->lastListIpRepository->store
        (
            $loginDTO->getUser()->getId(),
            $loginDTO->getIp(),
        );

        return $next($loginDTO);
    }
}
