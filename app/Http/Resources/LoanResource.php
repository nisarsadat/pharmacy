<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'customer' => $this->customer,
        'sale' => $this->sale,
        'total_amount' => $this->total_amount,
        'paid_amount' => $this->paid_amount,
        'remaining_amount' => $this->remaining_amount,
        'date' => $this->date,
        'note' => $this->note,
        'payments' => LoanPaymentResource::collection($this->whenLoaded('payments')),
    ];
}
}
