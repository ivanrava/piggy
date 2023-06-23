<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * App\Models\Transaction
 *
 * @property-read \App\Models\Account|null $account
 * @property-read \App\Models\Beneficiary|null $beneficiary
 * @property-read \App\Models\Category|null $category
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @property int $id
 * @property int $account_id
 * @property int $category_id
 * @property int $beneficiary_id
 * @property string $date
 * @property string $amount
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereBeneficiaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use HasFactory;

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public static function fromRequest(Request $request): Transaction
    {
        $transaction = new Transaction();
        $transaction->hydrateFromRequest($request);
        return $transaction;
    }

    public function hydrateFromRequest(Request $request): void
    {
        $this->account_id = $request->account_id;

        $beneficiary = $request->beneficiary();
        $beneficiary->save();
        $this->beneficiary_id = $beneficiary->id;

        $category = $request->category();
        $category->save();
        $this->category_id = $category->id;

        $this->notes = $request->notes;
        $this->amount = $request->amount;
        $this->date = $request->date;
    }
}
