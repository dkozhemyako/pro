<?php

namespace App\Services\Payments\Factory\DTO;

use App\Enums\CurrencyEnum;

class MakePaymentDTO
{
    protected string $orderId;

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

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }


}
