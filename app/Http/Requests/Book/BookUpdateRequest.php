<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('book'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:books,id'],
            'name' => ['required', 'string', 'between:1,100', 'unique:books,name'],
            'year' => ['required', 'integer', 'date_format:Y', 'digits:4', 'min:1970', 'before_or_equal:today'],
            'lang' => ['required', 'string', Rule::in(['en', 'ua', 'pl', 'de'])],
            'pages' => ['required', 'integer', 'between:10,55000'],
        ];
    }
}
