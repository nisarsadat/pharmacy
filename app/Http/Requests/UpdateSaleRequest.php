<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'note' => 'nullable|string',
            'date' => 'sometimes|date',

            'customer_id' => 'sometimes|exists:customers,id',
            'account_id' => 'sometimes|exists:accounts,id',
            'warehouse_id' => 'sometimes|exists:warehouses,id',

            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',

            'items' => 'sometimes|array|min:1',

            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.price' => 'required_with:items|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.exists' => 'Customer not found.',
            'account_id.exists' => 'Account not found.',
            'warehouse_id.exists' => 'Warehouse not found.',
            'items.array' => 'Items must be an array.',
        ];
    }
}