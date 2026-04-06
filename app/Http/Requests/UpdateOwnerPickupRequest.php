<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnerPickupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'account_id' => 'sometimes|required|exists:accounts,id',
            'owener_name' => 'sometimes|required|string|max:255',
            'owener_phone' => 'sometimes|required|string|max:20',
            'amount' => 'sometimes|required|numeric',
            'note' => 'nullable|string'
        ];
    }
}
