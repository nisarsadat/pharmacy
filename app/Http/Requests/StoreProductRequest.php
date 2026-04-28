<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        'name' => 'required|string',
        'main_price' => 'required|numeric',
        'sale_price' => 'nullable|numeric',

        'product_quantity' => 'required|integer|min:0',

        'product_company' => 'required|string',

        'date' => 'nullable|date',
        'expire_date' => 'nullable|date',
        'produced_date' => 'nullable|date',

        'note' => 'nullable|string',

        'warehouse_id' => 'required|exists:warehouses,id',
        'product_type_id' => 'required|exists:product_types,id',
    ];
}
}
