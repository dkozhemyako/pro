<?php

namespace App\Repositories\Books;

class BookIndexDTO
{

    public function __construct
    (
        protected string $startDate,
        protected string $endDate,
        protected array  $data,

    )
    {
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
     * @return string|null
     */
    public function getLang(): ?string
    {
        if (array_key_exists('lang', array: $this->data) === true) {
            return $this->data['lang'];
        }
        return null;
    }

}
