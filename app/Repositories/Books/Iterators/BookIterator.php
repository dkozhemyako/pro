<?php

namespace App\Repositories\Books\Iterators;

use App\Repositories\Categories\Iterators\CategoryIterator;

class BookIterator
{
    protected int $id;
    protected string $name;
    protected int $year;
    protected string $lang;
    protected int $pages;
    protected CategoryIterator $category;

    public function __construct(object $data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->year = $data->year;
        $this->lang = $data->lang;
        $this->pages = $data->pages;
        $this->category = new CategoryIterator($data);
    }

    /**
     * @return CategoryIterator
     */
    public function getCategory(): CategoryIterator
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return string
     */
    public function getLang(): string
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
