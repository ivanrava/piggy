<?php

namespace App\Models;

use App\Http\Requests\StoreCategoryRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;
    public $timestamps = false;

    public static function fromRequest(StoreCategoryRequest $request): Budget
    {
        $budget = new Budget();
        $budget->jan = $request->budget['jan'];
        $budget->feb = $request->budget['feb'];
        $budget->mar = $request->budget['mar'];
        $budget->apr = $request->budget['apr'];
        $budget->may = $request->budget['may'];
        $budget->jun = $request->budget['jun'];
        $budget->jul = $request->budget['jul'];
        $budget->aug = $request->budget['aug'];
        $budget->sep = $request->budget['sep'];
        $budget->oct = $request->budget['oct'];
        $budget->nov = $request->budget['nov'];
        $budget->dec = $request->budget['dec'];
        return $budget;
    }

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
