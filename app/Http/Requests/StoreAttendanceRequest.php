<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Attendance;
use Morilog\Jalali\Jalalian;

class StoreAttendanceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|string', // شمسی
            'status' => 'required|in:present,absent,leave',

            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',

            'note' => 'nullable|string',
        ];
    }

    // ✅ اصلاح دیتا قبل از validation
    protected function prepareForValidation()
    {
        if (in_array($this->status, ['absent', 'leave'])) {
            $this->merge([
                'check_in' => null,
                'check_out' => null,
            ]);
        }
    }

    // ✅ جلوگیری از تکرار (یک کارمند در یک روز فقط یکبار)
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (!$this->employee_id || !$this->date) {
                return;
            }

            $date = Jalalian::fromFormat('Y-m-d', $this->date)->toCarbon();

            $query = Attendance::where('employee_id', $this->employee_id)
                ->whereDate('date', $date);

            // در update رکورد خودش را نادیده بگیر
            if ($this->route('attendance')) {
                $query->where('id', '!=', $this->route('attendance')->id);
            }

            if ($query->exists()) {
                $validator->errors()->add('date', 'این کارمند در این تاریخ قبلاً حاضری داده است');
            }
        });
    }
}