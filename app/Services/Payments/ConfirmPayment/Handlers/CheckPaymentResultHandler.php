<?php

namespace App\Services\Payments\ConfirmPayment\Handlers;

use App\Services\Payments\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentInterface;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use PaymentFactory;

class CheckPaymentResultHandler implements ConfirmPaymentInterface
{

    public function __construct
    (
        protected PaymentFactory $paymentFactory,
    ) {
    }

    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $paymentService = $this->paymentFactory->getInstance(
            $confirmPaymentDTO->getPaymentsEnum(),
            config('payments_api')
        );

        $result = $paymentService->makePayment($confirmPaymentDTO->getPaymentId());

        if ($result->getPaymentStatusEnum() != 'COMPLETED') {
            $confirmPaymentDTO->setError('CheckPaymentResultHandler');
            return $confirmPaymentDTO;
        }

        $confirmPaymentDTO->setMakePaymentResultDTO($result);
        $confirmPaymentDTO->getMakePaymentResultDTO()->setPaymentsEnum($confirmPaymentDTO->getPaymentsEnum());
        return $next($confirmPaymentDTO);
    }
}
