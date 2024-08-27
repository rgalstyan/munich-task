<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class FilteredProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['integer', 'exists:users,id'],
            'category_id' => ['integer', 'exists:categories,id'],
            'search' => ['string', 'min:3', 'max:255'],
            'price' => ['array'],
            'price.min' => ['numeric'],
            'price.max' => ['numeric'],
            'per_page' => ['integer', 'min:1']
        ];
    }
}
