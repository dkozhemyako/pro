<?php

namespace App\Services\Payments\Stripe;

use App\Enums\CurrencyEnum;
use App\Services\Payments\DTO\MakePaymentDTO;
use App\Services\Payments\PaymentsInterface;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class StripeService implements PaymentsInterface
{
    public function __construct
    (
        protected StripeClient $stripeClient,
    ) {
    }

    public function makePayment(MakePaymentDTO $makePaymentDTO): bool
    {
        $result = $this->stripeClient->charges->create(
            [
                'amount' => $makePaymentDTO->getAmount() * 100,
                'currency' => $this->getCurrency($makePaymentDTO->getCurrency()),
                'source' => 'tok_mastercard',
                'description' => $makePaymentDTO->getDescription(),
            ]
        );

        return $result->status === 'succeeded';
    }

    private function getCurrency(CurrencyEnum $currencyEnum): string
    {
        return match ($currencyEnum) {
            CurrencyEnum::USD => 'usd',
            CurrencyEnum::EUR => 'eur',
            CurrencyEnum::UAH => 'uah',
        };
    }


}
