<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'initial_balance' => $this->initial_balance,
            'balance' => $this->balance(),
            'type' => $this->type->type,
            'account_type_id' => $this->type->id,
            'color' => '#'.$this->color,
            'icon' => $this->icon,
            'created_at' => $this->created_at,
            'last_update' => $this->updated_at,
            'description' => $this->description,
            'opening' => $this->opening,
            'closing' => $this->closing,
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            'in_transfers' => TransferResource::collection($this->whenLoaded('in_transfers')),
            'out_transfers' => TransferResource::collection($this->whenLoaded('out_transfers')),
        ];
    }
}
