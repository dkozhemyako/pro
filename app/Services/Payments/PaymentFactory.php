<?php

namespace App\Services\Payments;

use App\Enums\PaymentsEnum;
use App\Services\Payments\LiqPay\LiqPayService;
use App\Services\Payments\PayPal\PayPalService;
use App\Services\Payments\Stripe\StripeService;
use Illuminate\Contracts\Container\BindingResolutionException;
use PhpParser\Node\Expr\Match_;
use phpseclib3\File\ASN1\Maps\MaskGenAlgorithm;

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
