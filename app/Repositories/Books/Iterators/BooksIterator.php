<?php

namespace App\Repositories\Books\Iterators;

use ArrayIterator;
use Illuminate\Support\Collection;
use IteratorAggregate;


class BooksIterator implements IteratorAggregate
{
    protected array $data = ['0' => null];

    /**
     * @throws \Exception
     */
    public function __construct(Collection $collection)
    {
        foreach ($collection as $item) {
            if (key_exists($item->id, $this->data) === false) {
                $this->data[$item->id] = $item;
                $this->data[$item->id]->authors = collect();
            }
            $this->data[$item->id]->authors->add(
                (object)[
                    'id' => $item->author_id,
                    'name' => $item->author_name,
                ]
            );
        }
        unset($this->data['0']);

        foreach ($this->data as $item) {
            $this->data[$item->id] = new BookIterator($item);
        }
    }

    public function add(BookIterator $bookIterator): void
    {
        $this->data[] = $bookIterator;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
