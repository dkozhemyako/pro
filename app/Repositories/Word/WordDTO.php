<?php

namespace App\Repositories\Word;

use Illuminate\Database\Schema\Blueprint;

class WordDTO
{
    public function __construct(
        protected string $word,
        protected string $result,
    ) {
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

}
