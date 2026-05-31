<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'note' => 'nullable|string',
            'date' => 'required|date',

            'customer_id' => 'required|exists:customers,id',
            'account_id' => 'required|exists:accounts,id',
            'warehouse_id' => 'required|exists:warehouses,id',

            'discount' => 'nullable|numeric',
            'paid_amount' => 'required|numeric',

            'items' => 'required|array|min:1',

            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
        ];
    }
}
