<?php

namespace App\Services\Payments\Factory\LiqPay;

use App\Services\Payments\Factory\DTO\MakePaymentDTO;
use App\Services\Payments\Factory\PaymentsInterface;

class LiqPayService implements PaymentsInterface
{

    public function makePayment(MakePaymentDTO $makePayentDTO): bool
    {
        // TODO: Implement makePayment() method.
    }
}
