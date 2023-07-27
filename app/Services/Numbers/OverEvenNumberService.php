<?php

namespace App\Services\Numbers;

class OverEvenNumberService
{
    public function __construct
    (
        protected array $numbers,
    ) {
    }

    public function getOverEven(): int
    {
        $overEven = 0;
        foreach ($this->getNumbers() as $key => $value) {
            if ($value > 25 && $value % 2 === 0) {
                $overEven++;
            }
        }
        return $overEven;
    }

    /**
     * @return array
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

}
