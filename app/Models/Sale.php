<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'date',
        'customer_id',
        'account_id',
        'user_id', 
        'total_amount',
        'discount',
        'final_amount',
        'paid_amount',
        'due_amount',
        'payment_status'
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
  
}
