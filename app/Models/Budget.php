<?php

namespace App\Models;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateBudgetRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class Budget extends Model
{
    use HasFactory;
    public $timestamps = false;

    public static function fromRequest(StoreCategoryRequest|UpdateBudgetRequest $request): Budget
    {
        $budget = new Budget();
        $budget->hydrateFromRequest($request);
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

    public function hydrateFromRequest(Request $request): void
    {
        $this->jan = $request->budget['jan'];
        $this->feb = $request->budget['feb'];
        $this->mar = $request->budget['mar'];
        $this->apr = $request->budget['apr'];
        $this->may = $request->budget['may'];
        $this->jun = $request->budget['jun'];
        $this->jul = $request->budget['jul'];
        $this->aug = $request->budget['aug'];
        $this->sep = $request->budget['sep'];
        $this->oct = $request->budget['oct'];
        $this->nov = $request->budget['nov'];
        $this->dec = $request->budget['dec'];
    }
}
