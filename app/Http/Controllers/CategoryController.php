<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
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
    public function show(Request $request, Category $category): Response|array
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        $accounts = ($category->parent_category_id != null
            ? $category->transactions()
            : $request->user()->transactions()->whereIn('category_id', $category->children()->pluck('id')))
            ->join('accounts', 'accounts.id', '=', 'transactions.account_id')
            ->groupBy(['accounts.name', 'accounts.color', 'accounts.icon', 'accounts.id'])
            ->selectRaw('accounts.id, accounts.name, accounts.color, accounts.icon, SUM(amount) as sum, COUNT(*) as count')
            ->get();

        $beneficiaries = ($category->parent_category_id != null
            ? $category->transactions()
            : $request->user()->transactions()->whereIn('category_id', $category->children()->pluck('id')))
            ->join('beneficiaries', 'beneficiaries.id', '=', 'transactions.beneficiary_id')
            ->groupBy(['beneficiaries.name', 'beneficiaries.img', 'beneficiaries.id'])
            ->selectRaw('beneficiaries.id, beneficiaries.name, SUM(amount) as sum, COUNT(*) as count')
            ->get();

        return ['accounts' => $accounts, 'beneficiaries' => $beneficiaries];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category): Response
    {
        $category->hydrateFromRequest($request);
        $category->save();
        return response()->noContent();
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
}
