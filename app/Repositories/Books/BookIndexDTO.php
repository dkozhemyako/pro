<?php

namespace App\Repositories\Books;

use App\Enums\LangEnum;

class BookIndexDTO
{

    public function __construct
    (
        protected string $startDate,
        protected string $endDate,
        protected array $data,

    ) {
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getLastId(): ?int
    {
        if (array_key_exists('lastId', array: $this->data) === true) {
            return $this->data['lastId'];
        }
        return 0;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        if (array_key_exists('year', array: $this->data) === true) {
            return $this->data['year'];
        }
        return null;
    }

    /**
     * @return LangEnum|null
     */
    public function getLang(): ?LangEnum
    {
        if (array_key_exists('lang', array: $this->data) === true) {
            return LangEnum::from($this->data['lang']);
        }
        return null;
    }

}
