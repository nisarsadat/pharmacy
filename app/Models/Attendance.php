<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'note',
    ];

    // رابطه با کارمند
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // تبدیل تاریخ به شمسی در خروجی
    public function getDateShamsiAttribute()
    {
        return Jalalian::fromDateTime($this->date)->format('Y-m-d');
    }
}