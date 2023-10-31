<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $requestInput = $request->validated();
        $path = null;
        if ($request->hasFile('image')) {
            $publicPath = 'images/products';
            $image = $request->file('image');
            $image->store(options: public_path($publicPath));
            $path = $publicPath . '/' . $image->hashName();
        }
        $product = Product::create([...$requestInput, 'image' => $path]);
        if (!$product) {
            return response()->json(['message' => 'Erro ao criar um produto'], 500);
        }
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::find($product->id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = Product::find($product->id);

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $path = $product->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $request->merge(['image' => $path]);
        }
        $product->update($request->validated());
        return response()->json($product, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Produto deletado com sucesso'], 200);
    }
}
