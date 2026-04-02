<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'expense_category_id' => $this->expense_category_id,
            'account_id' => $this->account_id,
            'amount' => $this->amount,
            'note' => $this->note,
            'date' => $this->date,
            'created_at' => $this->created_at,
        ];
    }
}