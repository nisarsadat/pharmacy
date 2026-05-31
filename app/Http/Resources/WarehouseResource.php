<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'owner_phone' => $this->owner_phone,
            'owner_name' => $this->owner_name,
            'note' => $this->note,
            'created_at' => $this->created_at,
        ];
    }
}