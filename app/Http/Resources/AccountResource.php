<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

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
            'name' => $this->name,
            'initial_balance' => $this->initial_balance,
            'type' => $this->type->type,
            'color' => $this->color,
            'icon' => $this->icon,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
