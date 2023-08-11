<?php

namespace App\Http\Controllers\Payment;

use App\Enums\PaymentsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payent\PaymentMakeRequest;
use App\Services\Payments\DTO\MakePaymentDTO;
use App\Services\Payments\PaymentFactory;

class PaymentController extends Controller
{
    public function __construct
    (
        protected PaymentFactory $paymentFactory
    ) {
    }

    public function makePayment(PaymentMakeRequest $paymentMakeRequest)
    {
        $paymentService = $this->paymentFactory->getInstance(
            PaymentsEnum::from((int)$paymentMakeRequest->validated('paymentSystem'))
        );
        $paymentService->makePayment(
            new MakePaymentDTO(...$paymentMakeRequest->validated())
        );
    }
}
