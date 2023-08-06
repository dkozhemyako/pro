<?php

namespace App\Services\Payments\PayPal;

use App\Enums\CurrencyEnum;
use App\Services\Payments\DTO\MakePaymentDTO;
use App\Services\Payments\PaymentsInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService implements PaymentsInterface
{
    public function __construct
    (
        protected PayPalClient $payPalClient,
    ) {
    }

    public function makePayment(MakePaymentDTO $makePayentDTO): bool
    {
        $this->payPalClient->setApiCredentials(config('paypal'));
        $paypalToken = $this->payPalClient->getAccessToken();
        $response = $this->payPalClient->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $this->getCurrency($makePayentDTO->getCurrency()),
                        "value" => number_format($makePayentDTO->getAmount(), 2),
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
        }
    }

    private function getCurrency(CurrencyEnum $currencyEnum)
    {
        return match ($currencyEnum) {
            CurrencyEnum::USD => 'USD',
            CurrencyEnum::EUR => 'EUR',
            CurrencyEnum::UAH => 'UAH',
        };
    }
}


