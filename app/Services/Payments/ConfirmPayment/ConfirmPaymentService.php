<?php

namespace App\Services\Payments\ConfirmPayment;

use App\Enums\PaymentsEnum;
use App\Services\Payments\ConfirmPayment\Handlers\CheckPaymentResultHandler;
use App\Services\Payments\ConfirmPayment\Handlers\SavePaymentResultHandler;
use Illuminate\Pipeline\Pipeline;

class ConfirmPaymentService
{
    const HANDLERS = [
        CheckPaymentResultHandler::class,
        SavePaymentResultHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(PaymentsEnum $paymentsEnum, string $paymentId)
    {
        $paymentDTO = new ConfirmPaymentDTO($paymentsEnum, $paymentId);
        return $this->pipeline
            ->send($paymentDTO)
            ->through(self::HANDLERS)
            ->then(function (ConfirmPaymentDTO $paymentDTO) {
                return $paymentDTO;
            });
    }
}
