<?php

namespace App\Http\Controllers\Payment;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentsEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payent\PaymentConfirmRequest;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentService;
use App\Services\Payments\Factory\DTO\MakePaymentDTO;
use App\Services\Payments\Factory\PaymentFactory;
use Illuminate\Contracts\Container\BindingResolutionException;

class PaymentController extends Controller
{
    public function __construct
    (
        protected PaymentFactory $paymentFactory
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function createPayment(int $system)
    {
        $paymentService = $this->paymentFactory->getInstance(
            PaymentsEnum::from($system)
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
