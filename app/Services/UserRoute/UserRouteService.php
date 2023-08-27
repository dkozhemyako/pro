<?php

namespace App\Services\UserRoute;

use App\Repositories\UserRoute\UserRouteDTO;
use App\Repositories\UserRoute\UserRouteRepository;

class UserRouteService
{
    public function __construct
    (
        protected UserRouteRepository $userRouteRepository,
    ) {
    }

    public function handle(UserRouteDTO $userRouteDTO): int
    {
        return $this->userRouteRepository->store($userRouteDTO);
    }
}


