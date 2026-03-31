<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'date' => $this->date,
            'note' => $this->note,
            'account_type' => $this->account_type,
            'created_at' => $this->created_at,
        ];
    }
}
