<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        'name' => 'required|string',
        'last_name' => 'required|string',
        'father_name' => 'required|string',
        'phone_number' => 'required|string',
        'tazkira_number' => 'required|string|unique:customers,tazkira_number',
        'image' => 'nullable|image|mimes:jpg,png,jpeg',
        'note' => 'nullable|string',
    ];
}
}
