<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Redis;

class SingleRouteStorage
{
    protected const KEY = '_';
    protected const BASE_KEY_VALUE = 1;

    protected const EXPIRE = 600;

    public function get(int $userId, string $route): int
    {
        return (int)Redis::get($this->getKey($userId, $route));
    }

    public function set(int $userId, string $route, int $value = self::BASE_KEY_VALUE): void
    {
        Redis::set($this->getKey($userId, $route), $value, 'EX', self::EXPIRE);
    }

    public function incr(int $userId, string $route): void
    {
        Redis::incr($this->getKey($userId, $route));
    }

    private function getKey(int $userId, string $route): string
    {
        return $userId . self::KEY . $route;
    }

}
