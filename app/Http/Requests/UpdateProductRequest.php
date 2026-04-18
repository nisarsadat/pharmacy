<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{


    public function rules()
    {
        return [
            'warehouse_id' => 'sometimes|exists:warehouses,id',
            'product_type_id' => 'sometimes|exists:product_types,id',
            'code' => 'sometimes|string|unique:products,code,' . $this->product,
            'name' => 'sometimes|string|max:255',

            'main_price' => 'sometimes|numeric',
            'sale_price' => 'nullable|numeric',

            'main_stock_alert' => 'nullable|integer',
            'expire_date_alert' => 'nullable|integer',

            'date' => 'nullable|date',

            'product_amount_carton' => 'nullable|integer',
            'product_amount' => 'nullable|integer',

            'note' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png',
            'main_price_per_carton' => 'nullable|numeric',
            'main_price_per_quantity' => 'nullable|numeric',
            'total_price_per_carton' => 'nullable|numeric',
            'total_price_per_quantity' => 'nullable|numeric',
        ];
    }
}