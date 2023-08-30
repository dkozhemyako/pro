<?php

namespace App\Services\Cache;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;

use App\Repositories\Books\Iterators\BooksIterator;
use App\Services\Books\BookIteratorStorage;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function __construct
    (
        protected BookIteratorStorage $bookIteratorStorage,
    ) {
    }

    public function handle(BookIndexDTO $data): ?BooksIterator
    {
        return $this->bookIteratorStorage->get($data->getStartDate(), $data->getEndDate());
    }


}


