<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
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
            'note' => 'nullable|string',
            'date' => 'sometimes|date',
            'customer_id' => 'sometimes|exists:customers,id',
            'account_id' => 'required|exists:accounts,id',    
            'user_id' => 'sometimes|exists:users,id',
            'total_amount' => 'sometimes|numeric',
            'discount' => 'nullable|numeric',
            'final_amount' => 'sometimes|numeric',
            'paid_amount' => 'sometimes|numeric',
            'due_amount' => 'sometimes|numeric',
            'payment_status' => 'sometimes|string',
        ];
    }
}
