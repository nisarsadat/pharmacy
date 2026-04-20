<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'code' => $this->code,

            'warehouse_id' => $this->warehouse?->name,
            'product_type' => $this->productType?->name,

            'main_price' => $this->main_price,
            'sale_price' => $this->sale_price,

            'main_stock_alert' => $this->main_stock_alert,
            'expire_date_alert' => $this->expire_date_alert,

            'date' => $this->date,

            'product_amount_carton' => $this->product_amount_carton,
            'product_amount' => $this->product_amount,
            'images' => $this->images->map(function ($img) {
                return asset('storage/' . $img->image);
            }),

            'note' => $this->note,

            'created_at' => $this->created_at,
            'main_price_per_carton' => $this->main_price_per_carton,
            'main_price_per_quantity' => $this->main_price_per_quantity,
            'total_price_per_carton' => $this->total_price_per_carton,
            'total_price_per_quantity' => $this->total_price_per_quantity,
        ];
    }
}