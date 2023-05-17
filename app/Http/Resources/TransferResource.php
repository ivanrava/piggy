<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->date,
            'amount' => $this->amount,
            'notes' => $this->notes,
            'from' => new AccountResource($this->whenLoaded('from_account')),
            'to' => new AccountResource($this->whenLoaded('to_account'))
        ];
    }
}
