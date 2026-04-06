<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:20',
            'owner_name' => 'required|string|max:255',
            'note' => 'nullable|string',
        ];
    }
}