<?php

namespace App\Services\Payments\Factory\Stripe;

use App\Enums\CurrencyEnum;
use App\Services\Payments\Factory\DTO\MakePaymentDTO;
use App\Services\Payments\Factory\PaymentsInterface;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeService implements PaymentsInterface
{
    public function __construct
    (
        protected StripeClient $stripeClient,
    ) {
    }

    /**
     * @throws ApiErrorException
     */
    public function makePayment(string $paymentId): bool
    {
        $result = $this->stripeClient->paymentIntents->retrieve($paymentId);

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


    public function createPayment(MakePaymentDTO $makePaymentDTO): string
    {
        $result = $this->stripeClient->paymentIntents->create(
            [
                'amount' => $makePaymentDTO->getAmount() * 100,
                'currency' => $this->getCurrency($makePaymentDTO->getCurrency()),
            ]
        );
        return $result->client_secret;
    }
}
