<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'nullable|numeric',
            'date' => 'nullable|date',
            'note' => 'nullable|string',
            'account_type' => 'sometimes|required|string|max:255',
        ];
    }
}
