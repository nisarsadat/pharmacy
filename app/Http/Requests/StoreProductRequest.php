<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_type_id' => 'required|exists:product_types,id',
            'code' => 'required|string|unique:products,code',
            'name' => 'required|string|max:255',

            'main_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',

            'main_stock_alert' => 'nullable|integer',
            'expire_date_alert' => 'nullable|integer',

            'date' => 'nullable|date',

            'product_amount_carton' => 'nullable|integer',
            'product_amount' => 'nullable|integer',

            'note' => 'nullable|string',
            
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}