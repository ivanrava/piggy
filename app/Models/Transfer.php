<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * App\Models\Transfer
 *
 * @property-read \App\Models\Account|null $from_account
 * @property-read \App\Models\Account|null $to_account
 * @method static \Database\Factories\TransferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer query()
 * @property int $id
 * @property int $from_account_id
 * @property int $to_account_id
 * @property string $date
 * @property string $amount
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereFromAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereToAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transfer extends Model
{
    use HasFactory;

    public function from_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id', 'id');
    }

    public function to_account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id', 'id');
    }

    public static function fromRequest(Request $request): Transfer
    {
        $transfer = new Transfer();
        $transfer->hydrateFromRequest($request);
        return $transfer;
    }

    public function hydrateFromRequest(Request $request): void
    {
        $this->from_account_id = $request->from_account_id;
        $this->to_account_id = $request->to_account_id;
        $this->notes = $request->notes;
        $this->amount = $request->amount;
        $this->date = $request->date;

        $from = Account::find($request->from_account_id);
        $to = Account::find($request->to_account_id);
        if ($from->type->type == "Bank account" || $to->type->type == "Bank account")
            $this->checked = $request->checked;
        else
            $this->checked = true;
    }
}
