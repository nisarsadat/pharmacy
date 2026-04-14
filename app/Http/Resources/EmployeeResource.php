<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'name' => $this->name,
            'father_name' => $this->father_name,
            'last_name' => $this->last_name,
            'tazkira_number' => $this->tazkira_number,
            'phone_number' => $this->phone_number,
            'whatsapp_number' => $this->whatsapp_number,
            'gender' => $this->gender,
            'shift_from' => $this->shift_from,
            'shift_to' => $this->shift_to,
            'salary_amount' => $this->salary_amount,
            'salary_amount_per_day' => $this->salary_amount_per_day,
            'job_type' => $this->job_type,
            'entry_date' => $this->entry_date,
            'leave_date' => $this->leave_date,
            'work_days' => $this->work_days,
        ];
    }
}