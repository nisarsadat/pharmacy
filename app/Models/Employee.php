<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'image',
        'name',
        'father_name',
        'last_name',
        'tazkira_number',
        'phone_number',
        'whatsapp_number',
        'gender',
        'shift_from',
        'shift_to',
        'salary_amount',
        'salary_amount_per_day',
        'job_type',
        'entry_date',
        'leave_date',
        'work_days',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function salaries()
{
    return $this->hasMany(Salary::class);
}
}
