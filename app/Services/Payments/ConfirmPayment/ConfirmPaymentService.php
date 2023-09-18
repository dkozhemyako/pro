<?php

namespace App\Services\Payments\ConfirmPayment;

use App\Services\Payments\ConfirmPayment\Handlers\CheckPaymentResultHandler;
use App\Services\Payments\ConfirmPayment\Handlers\SavePaymentResultHandler;
use App\Services\Payments\ConfirmPayment\Handlers\SecurityPaymentResultHandler;
use Illuminate\Pipeline\Pipeline;
use PaymentsEnum;

class ConfirmPaymentService
{
    public const HANDLERS = [
        CheckPaymentResultHandler::class,
        SecurityPaymentResultHandler::class,
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
