<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'date',
        'note',
        'account_type'
    ];

    public function ownerPickups()
    {
        return $this->hasMany(OwnerPickup::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
   
}