<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sale_id',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'date',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }
}
