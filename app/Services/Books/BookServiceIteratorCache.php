<?php

namespace App\Services\Books;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Services\Cache\CacheService;
use Illuminate\Support\Facades\Redis;


class BookServiceIteratorCache
{
    public function __construct(
        protected BookRepository $bookRepository,
        protected CacheService $cacheService,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function indexIteratorNoCache(BookIndexDTO $data): BooksIterator
    {
        $tryCache = $this->cacheService->handle($data);
        if ($tryCache === null) {
            return $this->bookRepository->getByDataIterator($data);
        }
        return $tryCache;
    }
//
    /*
    Cache::remember($keys, $seconds,
        function() use ($data) {
            return $this->bookRepository->getByDataIteratorWithoutCache($data);
        });

    */
}
