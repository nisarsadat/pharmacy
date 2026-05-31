<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        'name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',

        'tazkira_number' => 'nullable|string|unique:employees,tazkira_number',

        'phone_number' => 'required|string|max:20',
        'whatsapp_number' => 'required|string|max:20',

        'gender' => 'nullable|in:male,female',

        'shift_from' => 'required',
        'shift_to' => 'required',

        'salary_amount_per_day' => 'required|numeric',

        'job_type' => 'nullable|string',

        'entry_date' => 'nullable|date',
        'leave_date' => 'nullable|date',

        'work_days' => 'required|integer|min:1',
    ];
}
}
