<?php

namespace App\Http\Requests\Payent;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentMakeRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min: 0', 'max: 100000'],
            'currency' => ['required', Rule::enum(CurrencyEnum::class)],
            'description' => ['sometime', 'string', 'max: 255'],
            'paymentSystem' => ['required', Rule::enum(PaymentsEnum::class)],

        ];
    }
}
