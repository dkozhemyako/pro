<?php

namespace App\Repositories\LastListIp;

use Illuminate\Support\Facades\DB;

class LastListIpRepository
{

    public function store(int $userId, string $ip): void
    {
        DB::table('last_login_ip')
            ->insert([
                'user_id' => $userId,
                'ip' => $ip,
                'created_at' => now(),
            ]);
    }
}
