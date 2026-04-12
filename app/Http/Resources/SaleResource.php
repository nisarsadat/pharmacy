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
            'customer_id' => $this->customer_id,
            'account_id' => $this->account_id,
            'user_id' => $this->user_id,
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'final_amount' => $this->final_amount,
            'paid_amount' => $this->paid_amount,
            'due_amount' => $this->due_amount,
            'payment_status' => $this->payment_status,
            'items' => SaleItemResource::collection($this->whenLoaded('items')),
        ];
    }
}

