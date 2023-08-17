<?php

namespace App\Repositories\Authors\Iterators;
use ArrayIterator;


class AuthorsIterator implements \IteratorAggregate
{
    protected array $data= [];
    public function __construct(object $data)
    {
            $this->data[] = new AuthorIterator($data);
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
