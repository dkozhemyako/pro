<?php

namespace App\Services\Payments\Factory\DTO;

use App\Enums\CurrencyEnum;

class MakePaymentDTO
{
    public function __construct
    (
        protected float $amount,
        protected CurrencyEnum $currency,
        protected string $description = '',
    ) {
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return CurrencyEnum
     */
    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

}
