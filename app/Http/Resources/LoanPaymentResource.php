<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanPaymentResource extends JsonResource
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
        'loan_id' => $this->loan_id,
        'account' => $this->account,
        'amount' => $this->amount,
        'date' => $this->date,
        'note' => $this->note,
    ];
}
}
