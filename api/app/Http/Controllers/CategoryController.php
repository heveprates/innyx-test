<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $requestInput = $request->validated();
        $category = Category::create($requestInput);
        if (!$category) {
            return response()->json(['message' => 'Erro ao criar uma categoria'], 500);
        }
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = Category::find($category->id);
        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        return response()->json($category, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = Category::find($category->id);
        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        $category->update($request->validated());
        return response()->json($category, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    }
}
