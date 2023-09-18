<?php

namespace App\Repositories\Payments;

use App\Repositories\Payments\Iterators\PaymentOrderIterator;
use App\Services\Payments\ConfirmPayment\ConfirmPaymentDTO;

use App\Services\Payments\Factory\DTO\MakePaymentDTO;
use Illuminate\Support\Facades\DB;
use MakePaymentResultDTO;

class PaymentResultRepository
{
    public function storePaymentResult(MakePaymentResultDTO $DTO)
    {
        DB::table('order_payment_result')
            ->insert([
                'user_id' => 1,
                'payment_system' => $DTO->getPaymentsEnum(),
                'payment_id' => $DTO->getPaymentId(),
                'order_id' => $DTO->getOrderId(),
                'success' => $DTO->getPaymentStatusEnum(),
                'amount' => $DTO->getAmount(),
                'currency' => $DTO->getCurrencyEnum(),
            ]);
    }

    public function storePaymentOrder(MakePaymentDTO $DTO)
    {
        DB::table('order_payment')
            ->insert([
                'amount' => $DTO->getAmount(),
                'order_id' => $DTO->getOrderId(),
            ]);
    }

    public function getAmountByOrder(ConfirmPaymentDTO $confirmPaymentDTO): PaymentOrderIterator
    {
        $result = DB::table('order_payment')
            ->select(['*'])
            ->where('order_id', '=', $confirmPaymentDTO->getMakePaymentResultDTO()->getOrderId())
            ->get();

        return $result->map(function ($item) {
            return new PaymentOrderIterator(...$item);
        });
    }
}
