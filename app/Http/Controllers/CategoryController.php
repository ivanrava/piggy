<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Stats\CrossStats;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return CategoryResource::collection($request->user()->categories()->get());
    }

    public function root(Request $request): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            $request->user()->categories()->whereParentCategoryId(null)->orderBy('type')->orderBy('name')->get()
        );
    }

    public function leaves(Request $request): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            $request->user()->categories()->whereNotNull('parent_category_id')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = Category::fromRequest($request);
        $category->save();
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category): Response|CategoryResource
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        $category->load('transactions');

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category): CategoryResource
    {
        $category->hydrateFromRequest($request);
        $category->save();
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category): Response
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        $category->delete();
        return response()->noContent();
    }

    public function stats_beneficiaries(Request $request, Category $category): Collection|Response|array
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        return CrossStats::get_beneficiary_stats_for($category->transactions_full_with_children());
    }

    public function stats_accounts(Request $request, Category $category): Collection|Response|array
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        return CrossStats::get_account_stats_for($category->transactions_full_with_children());
    }
}
