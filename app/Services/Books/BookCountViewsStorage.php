<?php

namespace App\Services\Books;

use Illuminate\Support\Facades\Redis;

class BookCountViewsStorage
{
    private const KEY_SAVE = 'count_book_views';

    public function get(): string
    {
        return Redis::get(self::KEY_SAVE);
    }
    public function set(string $value): void
    {
        Redis::set(self::KEY_SAVE, $value);
    }

    public function exists(): bool
    {
        return Redis::exists(self::KEY_SAVE);
    }

    public function delete(): void
    {
        Redis::del(self::KEY_SAVE);
    }
}
