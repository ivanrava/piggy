<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Account
 *
 * @method static \Database\Factories\AccountFactory factory($count = null, $state = [])
 * @method static Builder|Account newModelQuery()
 * @method static Builder|Account newQuery()
 * @method static Builder|Account query()
 * @property int $id
 * @property int $user_id
 * @property int $account_type_id
 * @property string $initial_balance
 * @property string $name
 * @property string $icon
 * @property string $color
 * @property string $opening
 * @property string|null $closing
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Account whereAccountTypeId($value)
 * @method static Builder|Account whereClosing($value)
 * @method static Builder|Account whereColor($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereDescription($value)
 * @method static Builder|Account whereIcon($value)
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereInitialBalance($value)
 * @method static Builder|Account whereName($value)
 * @method static Builder|Account whereOpening($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @method static Builder|Account whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transfer> $in_transfers
 * @property-read int|null $in_transfers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transfer> $out_transfers
 * @property-read int|null $out_transfers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\AccountType $type
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory;

    public function type(): BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function in_transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'to_account_id', 'id');
    }

    public function out_transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'from_account_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
    }

    public function balance()
    {
        $transfers_balance = $this->in_transfers()->sum('amount') - $this->out_transfers()->sum('amount');
        $out_balance = $this->transactions()->whereHas('category', function (Builder $query) {
            $query->where('type', '=', 'out');
        })->sum('amount');
        $in_balance = $this->transactions()->whereHas('category', function (Builder $query) {
            $query->where('type', '=', 'in');
        })->sum('amount');
        return round($transfers_balance - $out_balance + $in_balance + $this->initial_balance*1, 2);
    }
}
