<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'phone_number' => $this->phone_number,
            'tazkira_number' => $this->tazkira_number,
            'image' => $this->image 
            ? url('storage/' . $this->image) . '?t=' . time() 
            : null,
            'note' => $this->note,
        ];
    }
}