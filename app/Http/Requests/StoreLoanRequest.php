<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'customer_id' => 'required|exists:customers,id',
        'sale_id' => 'required|exists:sales,id',
        'total_amount' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'remaining_amount' => 'required|numeric',
        'date' => 'nullable|date',
        'note' => 'nullable|string',
    ];
}
}
