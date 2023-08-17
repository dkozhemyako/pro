<?php

namespace App\Services\Payments\Factory;

use App\Services\Payments\ConfirmPayment\MakePaymentResultDTO;
use App\Services\Payments\Factory\DTO\MakePaymentDTO;

interface PaymentsInterface
{
    public function makePayment(string $paymentId): MakePaymentResultDTO;

    public function createPayment(MakePaymentDTO $makePayentDTO): string;
}
