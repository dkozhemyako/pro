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
        protected BookIteratorStorage $bookIteratorStorage,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function indexIteratorNoCache(BookIndexDTO $data): BooksIterator
    {
        if ($this->bookIteratorStorage->has($data->getStartDate(), $data->getEndDate()) === false) {
            return $this->bookRepository->getByDataIterator($data);
        }
        return $this->cacheService->handle($data);
    }
//
    /*
    Cache::remember($keys, $seconds,
        function() use ($data) {
            return $this->bookRepository->getByDataIteratorWithoutCache($data);
        });

    */
}
