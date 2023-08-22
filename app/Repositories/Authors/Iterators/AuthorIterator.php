<?php

namespace App\Repositories\Authors\Iterators;

class AuthorIterator
{
    protected object $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->data->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->data->name;
    }

    /**
     * @return int
     */

}
