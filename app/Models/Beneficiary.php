<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * App\Models\Beneficiary
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BeneficiaryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary query()
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Beneficiary whereUserId($value)
 * @mixin \Eloquent
 */
class Beneficiary extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public static function fromRequest(Request $request): Beneficiary
    {
        $beneficiary = new Beneficiary();
        $beneficiary->hydrateFromRequest($request);
        return $beneficiary;
    }

    public function hydrateFromRequest(Request $request): void
    {
        $this->user_id = $request->user()->id;
        $this->name = $request->name;
        $this->img = $request->img;
    }
}
