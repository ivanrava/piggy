<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaryResource extends JsonResource
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
            'name' => $this->name,
            'img' => $this->img,
            'created_at' => $this->created_at->diffForHumans(),
            'transactions' => $this->relationLoaded('transactions') ? TransactionResource::collection($this->transactions) : []
        ];
    }
}
