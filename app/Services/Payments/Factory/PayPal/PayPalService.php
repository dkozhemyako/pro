<?php

namespace App\Services\Payments\Factory\PayPal;

use App\Enums\CurrencyEnum;
use App\Services\Payments\ConfirmPayment\MakePaymentResultDTO;
use App\Services\Payments\Factory\DTO\MakePaymentDTO;
use App\Services\Payments\Factory\PaymentsInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalService implements PaymentsInterface
{
    public function __construct
    (
        protected PayPalClient $payPalClient,
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function makePayment(string $paymentId): MakePaymentResultDTO
    {
        $this->payPalClient->setApiCredentials(config('paypal'));
        $paypalToken = $this->payPalClient->getAccessToken();
        $response = $this->payPalClient->capturePaymentOrder($paymentId);

        return new MakePaymentResultDTO
        (
            $response['status'],
            $response['purchase_units']['0']['payments']['captures']['0']['id'],
            $response['id'],
            $response['purchase_units']['0']['shipping']['name']['full_name'],
            $response['payer']['email_address'],
            $response['purchase_units']['0']['payments']['captures']['0']['amount']['value'],
            $response['purchase_units']['0']['payments']['captures']['0']['amount']['currency_code'],
        );
    }

    private function getCurrency(CurrencyEnum $currencyEnum): string
    {
        return match ($currencyEnum) {
            CurrencyEnum::USD => 'USD',
            CurrencyEnum::EUR => 'EUR',
            CurrencyEnum::UAH => 'UAH',
        };
    }

    /**
     * @throws \Throwable
     */
    public function createPayment(MakePaymentDTO $makePaymentDTO): string
    {
        $this->payPalClient->setApiCredentials(config('paypal'));
        $paypalToken = $this->payPalClient->getAccessToken();
        $response = $this->payPalClient->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $this->getCurrency($makePaymentDTO->getCurrency()),
                        "value" => number_format($makePaymentDTO->getAmount(), 2),
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            return $response['id'];
        }
        return '';
    }
}


