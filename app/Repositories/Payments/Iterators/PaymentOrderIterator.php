<?php

namespace App\Repositories\Payments\Iterators;

class PaymentOrderIterator
{
    public function __construct
    (
        protected int $id,
        protected string $orderID,
        protected float $amount,
    ) {
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
    public function getOrderID(): string
    {
        return $this->orderID;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

}
