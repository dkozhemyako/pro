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
            'paymentSystem' => ['required', Rule::enum(PaymentsEnum::class)],
        ];
    }
}
