<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerPickupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'account_id' => $this->account_id,
            'owener_name' => $this->owener_name,
            'owener_phone' => $this->owener_phone,
            'amount' => $this->amount,
            'note' => $this->note,

            // relation
            'account' => [
                'id' => $this->account?->id,
                'name' => $this->account?->name,
                'balance' => $this->account?->balance,
            ],

            'created_at' => $this->created_at,
        ];
    }
}