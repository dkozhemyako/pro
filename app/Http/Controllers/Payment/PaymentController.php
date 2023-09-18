<?php

namespace App\Http\Controllers\Payment;

use App\Http\Requests\Payent\PaymentConfirmRequest;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentService;
use dkv\test_package\Enum\CurrencyEnum;
use dkv\test_package\Payments\PaymentFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use dkv\test_package\Payments\DTO\MakePaymentDTO;
use dkv\test_package\Enum\PaymentsEnum;

class PaymentController extends Controller
{
    public function __construct
    (
        protected PaymentFactory $paymentFactory,

    ) {
    }

    /**
     * @throws \Throwable
     */
    public function createPayment(int $system): JsonResponse
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
    ): void {
        $data = $request->validated();
        $confirmPaymentService->handle(PaymentsEnum::from($system), $data['paymentId']);
    }
}
