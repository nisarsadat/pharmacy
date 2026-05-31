<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'father_name' => 'sometimes|string',
            'phone_number' => 'sometimes|string',
            'tazkira_number' => 'sometimes|string|unique:customers,tazkira_number,' . $this->customer->id,
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'note' => 'nullable|string',
        ];
    }
}
