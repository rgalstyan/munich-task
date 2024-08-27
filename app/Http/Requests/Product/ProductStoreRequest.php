<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'     => ['required', 'integer', 'exists:users,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:32'],
            'price'       => ['numeric']
        ];
    }
}
