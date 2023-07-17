<?php

namespace App\Repositories\Categories;


use Illuminate\Support\Carbon;

class CategoryStoreDTO
{
    public function __construct(
        protected string $name,
        protected Carbon $createdAt,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

}
