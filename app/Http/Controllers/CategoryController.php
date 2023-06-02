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
        return CategoryResource::collection(
            // Root categories
            $request->user()->categories()->whereParentCategoryId(null)->get()
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
    public function show(Request $request, Category $category): CategoryResource|Response
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        $category->load('transactions');

        return new CategoryResource($category->load('children'));
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
