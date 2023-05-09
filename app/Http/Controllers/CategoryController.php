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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): Response
    {
        $category = new Category();
        $category->user_id = $request->user()->id;
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->parent_category_id = $request->parent_category_id;
        $category->type = $request->type;
        $category->save();
        return response()->noContent(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category): CategoryResource|Response
    {
        if ($category->user_id != $request->user()->id)
            return response()->noContent(404);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category): Response
    {
        $category->user_id = $request->user()->id;
        $category->name = $request->name;
        $category->icon = $request->icon;
        $category->parent_category_id = $request->parent_category_id;
        $category->type = $request->type;
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
