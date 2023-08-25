<?php

namespace App\Services\Cache;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;

use App\Repositories\Books\Iterators\BooksIterator;
use Illuminate\Support\Facades\Cache;

class CacheService
{

    public function handle(BookIndexDTO $data): ?BooksIterator
    {
        return Cache::get($data->getStartDate() . $data->getEndDate());
    }


}


