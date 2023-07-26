<?php

namespace App\Models;

use App\Http\Requests\StorePropertyVariationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyVariation extends Model
{
    use HasFactory;

    public static function fromRequest(StorePropertyVariationRequest $request): PropertyVariation
    {
        $variation = new PropertyVariation();
        $variation->hydrateFromRequest($request);
        return $variation;
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    private function hydrateFromRequest(StorePropertyVariationRequest $request): void
    {
        $this->notes = $request->notes;
        $this->amount = $request->amount;
        $this->date = $request->date;
        $this->type = $request->type;
    }
}
