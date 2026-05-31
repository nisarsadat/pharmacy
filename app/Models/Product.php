<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'main_price',
        'sale_price',
        'product_quantity',
        'product_company',
        'date',
        'expire_date',
        'produced_date',
        'note',
        'warehouse_id',
        'product_type_id',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
