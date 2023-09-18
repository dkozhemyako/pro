<?php

namespace App\Http\Controllers\Payment;

use App\Http\Requests\Payent\PaymentConfirmRequest;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentService;
use CurrencyEnum;
use Illuminate\Routing\Controller;
use MakePaymentDTO;
use PaymentFactory;
use PaymentsEnum;

class PaymentController extends Controller
{
    public function __construct
    (
        protected PaymentFactory $paymentFactory

    ) {
    }

    public function createPayment(int $system)
    {
        $paymentService = $this->paymentFactory->getInstance(
            PaymentsEnum::from($system),
            config('payments_api')

        );
        $makePaymentDTO = new MakePaymentDTO
        (
            '20.10',
            CurrencyEnum::USD,
        );
        $orderID = $paymentService->createPayment($makePaymentDTO);

        return response()->json([
            'order' => ['id' => $orderID],
        ]);
    }

    public function confirmPayment
    (
        PaymentConfirmRequest $request,
        $system,
        ConfirmPaymentService $confirmPaymentService,
    ) {
        $data = $request->validated();
        $confirmPaymentService->handle(PaymentsEnum::from($system), $data['paymentId']);
    }
}
