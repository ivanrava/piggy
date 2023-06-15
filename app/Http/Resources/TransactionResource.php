<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'category' => new CategoryResource($this->category),
            'beneficiary' => new BeneficiaryResource($this->beneficiary),
            'account' => new AccountResource($this->account)
        ];
    }
}
