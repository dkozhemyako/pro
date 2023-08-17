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
        if (property_exists($this->data, 'author_id') === true) {
            return $this->data->author_id;
        }
        return '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (property_exists($this->data, 'author_name') === true) {
            return $this->data->author_name;
        }
        return '';
    }

    /**
     * @return int
     */

}
