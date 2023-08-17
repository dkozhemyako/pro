<?php

namespace App\Http\Requests\Payent;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentConfirmRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'paymentId' => ['required', 'string', 'min: 0', 'max: 999', 'unique:order_payment_result,payment_id'],
        ];
    }
}
