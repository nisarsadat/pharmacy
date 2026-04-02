<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'expense_category_id' => 'sometimes|exists:expense_categories,id',
            'account_id' => 'sometimes|exists:accounts,id',
            'amount' => 'sometimes|numeric|min:0',
            'date' => 'nullable|date',
            'note' => 'nullable|string'
        ];
    }
}