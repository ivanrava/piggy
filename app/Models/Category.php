<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * App\Models\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @property int $id
 * @property int $user_id
 * @property int|null $parent_category_id
 * @property string $name
 * @property string $type
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereIcon($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereParentCategoryId($value)
 * @method static Builder|Category whereType($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereUserId($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;
    protected $with = ['children'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }

    public static function fromRequest(Request $request): Category
    {
        $category = new Category();
        $category->hydrateFromRequest($request);
        return $category;
    }

    public function hydrateFromRequest(Request $request): void
    {
        $this->user_id = $request->user()->id;
        $this->name = $request->name;
        $this->icon = $request->icon;
        $this->parent_category_id = $request->parent_category_id;
        if ($request->parent_category_id !== null)
            $this->type = $this->parent->type;
        else
            $this->type = $request->type;
    }

    public function account_stats()
    {
        return ($this->parent_category_id != null
            ? $this->transactions()
            : $this->user()->transactions()->whereIn('category_id', $this->children()->pluck('id')))
            ->join('accounts', 'accounts.id', '=', 'transactions.account_id')
            ->groupBy(['accounts.name', 'accounts.color'])
            ->selectRaw('accounts.name, accounts.color, SUM(amount) as sum, COUNT(*) as count')
            ->get();
    }

    public function beneficiary_stats()
    {
        return ($this->parent_category_id != null
            ? $this->transactions()
            : $this->user()->transactions()->whereIn('category_id', $this->children()->pluck('id')))
            ->join('beneficiaries', 'beneficiaries.id', '=', 'transactions.beneficiary_id')
            ->groupBy(['beneficiaries.name'])
            ->selectRaw('beneficiaries.name, SUM(amount) as sum, COUNT(*) as count')
            ->get();
    }
}
