<?php

namespace App\Services\Books;

use App\Repositories\Books\Iterators\BooksIterator;
use Closure;
use Illuminate\Support\Facades\Cache;


class BookIteratorStorage
{
    protected const KEY = '_';
    protected const CACHE_SECONDS_LIVE = 30;

    /**
     * @throws \Exception
     */
    public function get(string $startDate, string $endDate): BooksIterator
    {
        $result = Cache::get($this->getKey($startDate, $endDate));
        return new BooksIterator($result);
    }

    public function remember(string $startDate, string $endDate, Closure $data): mixed
    {
        return Cache::remember($this->getKey($startDate, $endDate), self::CACHE_SECONDS_LIVE, $data);
    }

    private function getKey(string $startDate, string $endDate): string
    {
        return $startDate . self::KEY . $endDate;
    }

    public function has(string $startDate, string $endDate): bool
    {
        return Cache::has($this->getKey($startDate, $endDate));
    }
}
