<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['nullable', 'string', 'min:8', 'max:128'],
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id)
            ],
        ];
    }
}
