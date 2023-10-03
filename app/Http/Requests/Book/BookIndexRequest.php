<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookIndexRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate'],
            'year' => ['sometimes', 'integer', 'date_format:Y', 'min:1970', 'before_or_equal:today'],
            'lang' => ['sometimes', 'string', Rule::in(['en', 'ua', 'pl', 'de'])],
            'lastId' => ['sometimes', 'integer', 'min: 0'],
        ];
    }
}
