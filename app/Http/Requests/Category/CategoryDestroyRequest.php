<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryDestroyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('category'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:categories,id']
        ];
    }
}
