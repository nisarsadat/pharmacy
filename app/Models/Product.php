<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'product_type_id',
        'code',
        'name',
        'main_price',
        'sale_price',
        'main_stock_alert',
        'expire_date_alert',
        'date',
        'product_amount_carton',
        'product_amount',
        'note',
        'main_price_per_carton',
        'main_price_per_quantity',
        'total_price_per_carton',
        'total_price_per_quantity',
    ];

    // Relations
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
