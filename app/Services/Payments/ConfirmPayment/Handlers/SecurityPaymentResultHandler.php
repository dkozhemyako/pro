<?php

namespace App\Services\Payments\ConfirmPayment\Handlers;

use App\Repositories\Payments\PaymentResultRepository;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentInterface;
use App\Services\Payments\Factory\PaymentFactory;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;

class SecurityPaymentResultHandler implements ConfirmPaymentInterface
{

    public function __construct
    (
        protected PaymentFactory $paymentFactory,
        protected PaymentResultRepository $paymentResultRepository,
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $paymentOrder = $this->paymentResultRepository->getAmountByOrder($confirmPaymentDTO);
        if ($paymentOrder->getAmount() !== $confirmPaymentDTO->getMakePaymentResultDTO()->getAmount()) {
            return $confirmPaymentDTO;
        }

        return $next($confirmPaymentDTO);
    }
}
