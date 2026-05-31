<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'owner_phone' => 'sometimes|string|max:20',
            'owner_name' => 'sometimes|string|max:255',
            'note' => 'nullable|string',
        ];
    }
}