<?php

namespace App\Services\Payments\ConfirmPayment;

use App\Enums\PaymentsEnum;

class ConfirmPaymentDTO
{
    protected MakePaymentResultDTO $makePaymentResultDTO;
    protected string $error;

    public function __construct
    (
        protected PaymentsEnum $paymentsEnum,
        protected $paymentId,
    ) {
    }

    /**
     * @return MakePaymentResultDTO
     */
    public function getMakePaymentResultDTO(): MakePaymentResultDTO
    {
        return $this->makePaymentResultDTO;
    }

    /**
     * @param MakePaymentResultDTO $makePaymentResultDTO
     */
    public function setMakePaymentResultDTO(MakePaymentResultDTO $makePaymentResultDTO): void
    {
        $this->makePaymentResultDTO = $makePaymentResultDTO;
    }

    /**
     * @return bool
     */

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * @param bool $paymentResult
     */

    /**
     * @return PaymentsEnum
     */
    public function getPaymentsEnum(): PaymentsEnum
    {
        return $this->paymentsEnum;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

}
