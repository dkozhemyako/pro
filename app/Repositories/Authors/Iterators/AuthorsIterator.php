<?php

namespace App\Repositories\Authors\Iterators;

use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;


class AuthorsIterator implements IteratorAggregate
{
    protected array $data = [];

    public function __construct(Collection $collection)
    {
        foreach ($collection as $item) {
            $this->data[] = new AuthorIterator($item);
        }
    }

    public function add(AuthorIterator $authorIterator): void
    {
        $this->data[] = $authorIterator;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
