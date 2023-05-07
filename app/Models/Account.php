<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @mixin \Eloquent
 */
class Account extends Model
{
    use HasFactory;

    public function type(): BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }
}
