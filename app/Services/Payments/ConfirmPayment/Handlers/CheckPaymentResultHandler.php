<?php

namespace App\Services\Payments\ConfirmPayment\Handlers;

use App\Services\Payments\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentInterface;
use App\Services\Payments\Factory\PaymentFactory;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;

class CheckPaymentResultHandler implements ConfirmPaymentInterface
{

    public function __construct
    (
        protected PaymentFactory $paymentFactory,
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $paymentService = $this->paymentFactory->getInstance(
            $confirmPaymentDTO->getPaymentsEnum()
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
