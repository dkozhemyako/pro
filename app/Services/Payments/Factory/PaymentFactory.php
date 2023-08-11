<?php

namespace App\Services\Payments\Factory;

use App\Enums\PaymentsEnum;
use App\Services\Payments\Factory\LiqPay\LiqPayService;
use App\Services\Payments\Factory\PayPal\PayPalService;
use App\Services\Payments\Factory\Stripe\StripeService;
use Illuminate\Contracts\Container\BindingResolutionException;

class PaymentFactory
{
    /**
     * @throws BindingResolutionException
     */
    public function getInstance(PaymentsEnum $paymentsEnum): PaymentsInterface
    {
        return match ($paymentsEnum) {
            PaymentsEnum::STRIPE => app()->make(StripeService::class),
            PaymentsEnum::PAYPAL => app()->make(PayPalService::class),
            PaymentsEnum::LIQPAY => app()->make(LiqPayService::class),
        };
    }
}
