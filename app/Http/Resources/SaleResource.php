<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'note' => $this->note,
            'date' => $this->date,

            'customer' => $this->customer,
            'account' => $this->account,
            'warehouse' => $this->warehouse,

            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'final_amount' => $this->final_amount,
            'paid_amount' => $this->paid_amount,
            'due_amount' => $this->due_amount,

            'items' => $this->items,

            'created_at' => $this->created_at,
        ];
    }
}
