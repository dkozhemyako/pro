<?php

namespace App\Services\Payments\Factory\Stripe;

use App\Services\Payments\Factory\DTO\CreateTokenDTO;
use Stripe\Exception\CardException;
use Stripe\StripeClient;

class CreateTokenService
{
    public function __construct
    (
        protected StripeClient $stripeClient,
    ) {
    }

    public function createToken(CreateTokenDTO $createTokenDTO)
    {
        $token = null;
        try {
            $token = $this->stripeClient->tokens->create([
                'card' => [
                    'number' => $createTokenDTO->getCardNumber(),
                    'exp_month' => $createTokenDTO->getMonth(),
                    'exp_year' => $createTokenDTO->getYear(),
                    'cvc' => $createTokenDTO->getCvc(),
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (\Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }
}
