<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler;


use App\Enums\LangEnum;
use Illuminate\Support\Carbon;

class CreateBookTelegramDTO
{
    protected string $name;
    protected int $year;
    protected LangEnum $lang;
    protected int $categoryId;
    protected int $pages;
    protected string $message;

    public function __construct(
        protected string $argument,
        protected int $senderId,
    ) {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getArgument(): string
    {
        return $this->argument;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return LangEnum
     */
    public function getLang(): LangEnum
    {
        return $this->lang;
    }

    /**
     * @param LangEnum $lang
     */
    public function setLang(LangEnum $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     */
    public function setPages(int $pages): void
    {
        $this->pages = $pages;
    }

}
