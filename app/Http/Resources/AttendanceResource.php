<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'employee_name' => $this->employee->name ?? null,

            // شمسی برای کاربر
            'date' => $this->date_shamsi,

            'status' => $this->status,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'note' => $this->note,
        ];
    }
}