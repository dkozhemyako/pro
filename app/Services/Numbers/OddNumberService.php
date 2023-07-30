<?php

namespace App\Services\Numbers;

class OddNumberService
{
    public function __construct
    (
        protected array $numbers,
    ) {
    }

    public function getOdd(): int
    {
        $odd = 0;
        foreach ($this->getNumbers() as $key => $value) {
            if ($value % 2 > 0) {
                $odd++;
            }
        }
        return $odd;
    }

    /**
     * @return array
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

}
