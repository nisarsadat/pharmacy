<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'main_price_per_carton',
        'main_price_per_quantity',
        'total_price_per_carton',
        'total_price_per_quantity',
        'quantity_product_amount',
        'quantity_per_carton'
    ];
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}