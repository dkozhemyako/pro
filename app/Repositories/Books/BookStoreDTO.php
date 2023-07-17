<?php

namespace App\Repositories\Books;


use App\Enums\LangEnum;
use Illuminate\Support\Carbon;

class BookStoreDTO
{
    public function __construct(
        protected string $name,
        protected int $year,
        protected LangEnum $lang,
        protected int $pages,
        protected Carbon $createdAt,
        protected int $categoryId,
    ) {
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }


    /**
     * @return string
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return LangEnum
     */
    public function getLang(): LangEnum
    {
        return $this->lang;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

}
