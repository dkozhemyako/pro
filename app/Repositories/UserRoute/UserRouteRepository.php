<?php

namespace App\Repositories\UserRoute;

use Illuminate\Support\Facades\DB;

class UserRouteRepository
{
    public function store(UserRouteDTO $userRouteDTO): int
    {
        return DB::table('user_route_action')
            ->insertGetId([
                'user_id' => $userRouteDTO->getUserId(),
                'method' => $userRouteDTO->getMethodEnum(),
                'route' => $userRouteDTO->getRoute(),
                'created_at' => now(),
            ]);
    }
}
