<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $leaves = $request->user()->categories()->where('parent_category_id', '!=', null);
        $leaves_with_budget = $leaves->with(['budget', 'transactions' => fn (Builder $query) => Transaction::groupByMonthlyCategory($query) ])->get();
        $leaves_with_budget->transform(fn (Category $category) => Budget::buildExpendituresFromGroupedTransactions($category));

        return CategoryResource::collection($leaves_with_budget);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //
    }
}
