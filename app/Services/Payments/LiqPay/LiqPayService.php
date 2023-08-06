<?php

namespace App\Services\Payments\LiqPay;

use App\Services\Payments\DTO\MakePaymentDTO;
use App\Services\Payments\PaymentsInterface;

class LiqPayService implements PaymentsInterface
{

    public function makePayment(MakePaymentDTO $makePayentDTO): bool
    {
        // TODO: Implement makePayment() method.
    }
}
