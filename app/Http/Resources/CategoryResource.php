<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'type' => $this->type,
            'icon' => $this->icon,
            'parent' => $this->relationLoaded('parent') ? new CategoryResource($this->parent) : null,
            'parent_category_id' => $this->parent_category_id,
            'children' => $this->relationLoaded('children') ? CategoryResource::collection($this->children) : [],
            'transactions' => $this->relationLoaded('transactions') ? TransactionResource::collection($this->transactions) : []
        ];
    }
}
