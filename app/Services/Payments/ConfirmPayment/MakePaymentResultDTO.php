<?php

namespace App\Services\Payments\ConfirmPayment;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentsEnum;
use App\Enums\PaymentStatusEnum;


class MakePaymentResultDTO
{
    protected PaymentsEnum $paymentsEnum;

    public function __construct
    (
        protected PaymentStatusEnum $paymentStatusEnum,
        protected string $orderId,
        protected string $paymentId,
        protected string $clientName,
        protected string $clientEmail,
        protected float $amount,
        protected CurrencyEnum $currencyEnum,

    ) {
    }

    /**
     * @return PaymentsEnum
     */
    public function getPaymentsEnum(): PaymentsEnum
    {
        return $this->paymentsEnum;
    }

    /**
     * @param PaymentsEnum $paymentsEnum
     */
    public function setPaymentsEnum(PaymentsEnum $paymentsEnum): void
    {
        $this->paymentsEnum = $paymentsEnum;
    }

    /**
     * @return PaymentStatusEnum
     */
    public function getPaymentStatusEnum(): PaymentStatusEnum
    {
        return $this->paymentStatusEnum;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @return string
     */
    public function getClientEmail(): string
    {
        return $this->clientEmail;
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
    public function getCurrencyEnum(): CurrencyEnum
    {
        return $this->currencyEnum;
    }

    /**
     * @return string
     */

}
