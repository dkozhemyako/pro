<?php

namespace App\Repositories\Categories\Iterators;

class CategoryIterator
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

        if (property_exists($this->data, 'category_id') === true) {
            return $this->data->category_id;
        }
        return $this->data->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {

        if (property_exists($this->data, 'category_name') === true) {
            return $this->data->category_name;
        }
        return $this->data->name;
    }

    /**
     * @return int
     */

}
