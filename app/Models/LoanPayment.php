<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'account_id',
        'amount',
        'date',
        'note',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
