<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:1,100', 'unique:books,name'],
            'year' => ['required', 'integer', 'date_format:Y', 'min:1970', 'before_or_equal:today'],
            'lang' => ['required', 'string', Rule::in(['en', 'ua', 'pl', 'de'])],
            'pages' => ['required', 'integer', 'between:10,55000'],
            'categoryId' => ['required', 'integer', 'exists:categories,id'],

        ];
    }
}
