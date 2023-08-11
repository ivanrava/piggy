<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBudgetRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Response;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $leaves = $request->user()->categories()->with('parent')->where('parent_category_id', '!=', null)->orderBy('name');
        $leaves_with_budget = $leaves->with(['budget', 'transactions' => fn (Builder $query) => Transaction::groupByMonthlyCategory($query, $request->input('year')) ])->get();
        $leaves_with_budget->transform(fn (Category $category) => Budget::buildExpendituresFromGroupedTransactions($category));

        return CategoryResource::collection($leaves_with_budget->sortBy(['parent.name', 'name']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, Category $category): CategoryResource
    {
        $category->hydrateFromRequest($request);
        $category->save();
        if (!$request->filled('budget_overall')) {
            if ($budget = $category->budget) {
                $budget->hydrateFromRequest($request);
            } else {
                $budget = Budget::fromRequest($request);
            }
            $category->budget()->save($budget);
        } else {
            Budget::where('category_id', $category->id)->delete();
        }
        Category::where('parent_category_id', $category->id)->update(['type' => $category->type]);
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }

    public function years()
    {
        return Transaction::groupBy('year')
            ->selectRaw("date_trunc('year', date) as year")
            ->orderBy('year')
            ->get()
            ->pluck('year')
            ->map(fn ($year) => Carbon::parse($year)->format('Y'));
    }
}
