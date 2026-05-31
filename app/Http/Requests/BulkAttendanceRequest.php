<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkAttendanceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'attendances' => 'required|array',

            'attendances.*.employee_id' => 'required|exists:employees,id',
            'attendances.*.date' => 'required|date',
            'attendances.*.status' => 'required|in:present,absent,leave',

            'attendances.*.check_in' => 'nullable',
            'attendances.*.check_out' => 'nullable',
            'attendances.*.note' => 'nullable|string',
        ];
    }
}