<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoanPaymentRequest extends FormRequest
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
        'loan_id' => 'required|exists:loans,id',
        'account_id' => 'required|exists:accounts,id',
        'amount' => 'required|numeric|min:1',
        'date' => 'required|date',
        'note' => 'nullable|string',
    ];
}
}
