<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => ['required', 'integer', 'exists:users,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'title'       => ['nullable', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'min:32'],
            'price'       => ['nullable', 'numeric'],
        ];
    }
}
