<?php

namespace App\Services\Numbers;

class LessNumberService
{
    public function __construct
    (
        protected array $numbers,
    ) {
    }

    public function getLess(): int
    {
        $less = 0;
        foreach ($this->getNumbers() as $key => $value) {
            if ($value < 10) {
                $less++;
            }
        }
        return $less;
    }

    /**
     * @return array
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

}
