<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;
    protected $appends = ['value'];

    public function variations(): HasMany
    {
        return $this->hasMany(PropertyVariation::class);
    }

    private function additions(): HasMany
    {
        return $this->variations()->where('type', 'in');
    }

    private function subtractions(): HasMany
    {
        return $this->variations()->where('type', 'out');
    }

    protected function value(): Attribute
    {
        return new Attribute(
            get: fn () => $this->initial_value + $this->additions()->sum('amount') - $this->subtractions()->sum('amount'),
        );
    }
}
