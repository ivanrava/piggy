<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'jan' => $this->jan,
            'feb' => $this->feb,
            'mar' => $this->mar,
            'apr' => $this->apr,
            'may' => $this->may,
            'jun' => $this->jun,
            'jul' => $this->jul,
            'aug' => $this->aug,
            'sep' => $this->sep,
            'oct' => $this->oct,
            'nov' => $this->nov,
            'dec' => $this->dec,
        ];
    }
}
