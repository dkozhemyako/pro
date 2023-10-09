<?php

namespace App\Services\Books;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CountBookViewsService
{
    private const BASIC_COUNT_VALUE = 1;
    public function __construct(
        protected BookCountViewsStorage $storage,
        protected CountService $service,
    ){}

    public function handle(int $bookId): void {

        $array = [];

        if ($this->storage->exists() == true){
            $result = $this->service->handle($bookId, json_decode($this->storage->get(), true));
            $this->storage->set(json_encode($result));
            return;
        }

        $array[$bookId] = self::BASIC_COUNT_VALUE;
        $this->storage->set(json_encode($array));

    }
}
