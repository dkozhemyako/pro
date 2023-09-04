<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Redis;

class MultipleRouteStorage
{
    protected const KEY = '_user';
    protected const BASE_KEY_VALUE = 1;

    protected const EXPIRE = 600;

    public function get(int $userId): int
    {
        return (int)Redis::get($this->getKey($userId));
    }

    public function set(int $userId, int $value = self::BASE_KEY_VALUE): void
    {
        Redis::set($this->getKey($userId), $value, 'EX', self::EXPIRE);
    }

    public function incr(int $userId): void
    {
        Redis::incr($this->getKey($userId));
    }

    private function getKey(int $userId): string
    {
        return $userId . self::KEY;
    }

}
