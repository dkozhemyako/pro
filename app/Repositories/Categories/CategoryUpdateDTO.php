<?php

namespace App\Repositories\Categories;


use Illuminate\Support\Carbon;

class CategoryUpdateDTO
{
    public function __construct(
        protected string $name,
        protected Carbon $updatedAt,
    ) {
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
