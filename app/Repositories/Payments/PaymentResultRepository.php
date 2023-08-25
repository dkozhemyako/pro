<?php

namespace App\Repositories\Payments;

use App\Services\Payments\ConfirmPayment\MakePaymentResultDTO;
use Illuminate\Support\Facades\DB;

class PaymentResultRepository
{
    public function store(MakePaymentResultDTO $DTO)
    {
        DB::table('order_payment_result')
            ->insert([
                'user_id' => auth()->user()->id,
                'payment_system' => $DTO->getPaymentsEnum(),
                'payment_id' => $DTO->getPaymentId(),
                'order_id' => $DTO->getOrderId(),
                'success' => $DTO->getPaymentStatusEnum(),
                'amount' => $DTO->getAmount(),
                'currency' => $DTO->getCurrencyEnum(),

            ]);
    }
}
