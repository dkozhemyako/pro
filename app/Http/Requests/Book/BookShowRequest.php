<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookShowRequest extends FormRequest
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
            'id' => ['required', 'integer', 'numeric']
        ];
    }


}
