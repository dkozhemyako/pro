<?php

namespace App\Services\Numbers;

class EvenNumberService
{
    public function __construct
    (
        protected array $numbers,
    ) {
    }

    public function getEven(): int
    {
        $even = 0;
        foreach ($this->getNumbers() as $key => $value) {
            if ($value % 2 === 0) {
                $even++;
            }
        }
        return $even;
    }

    /**
     * @return array
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

}
