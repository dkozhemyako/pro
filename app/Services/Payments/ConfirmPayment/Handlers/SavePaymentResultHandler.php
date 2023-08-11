<?php

namespace App\Services\Payments\ConfirmPayment\Handlers;

use App\Repositories\Payments\PaymentResultRepository;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentInterface;
use App\Services\Payments\Factory\PaymentFactory;
use Closure;

class SavePaymentResultHandler implements ConfirmPaymentInterface
{

    public function __construct
    (
        protected PaymentResultRepository $paymentResultRepository,
    ) {
    }

    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $this->paymentResultRepository->store($confirmPaymentDTO->getMakePaymentResultDTO());
        return $next($confirmPaymentDTO);
    }
}
