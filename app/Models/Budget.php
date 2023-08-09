<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function buildExpendituresFromGroupedTransactions(Category $category): Category
    {
        $expenditures = ['jan'=>0,'feb'=>0,'mar'=>0,'apr'=>0,'may'=>0,'jun'=>0,'jul'=>0,'aug'=>0,'sep'=>0,'oct'=>0,'nov'=>0,'dec'=>0];
        $category['transactions']->each(function ($month_data) use (&$expenditures) {
            $expenditures[strtolower(Carbon::parse($month_data['month'])->format('M'))] = $month_data['sum'];
        });
        unset($category['transactions']);
        $category['expenditures'] = $expenditures;
        return $category;
    }
}
