<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ProductServiceInterface;
use App\DataTransferObjects\Product\ProductCreateDTO;
use App\DataTransferObjects\Product\ProductUpdateDTO;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductServiceInterface $productService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollectionResource(
            $this->productService->paginate(1, search: 'KIN')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create(ProductCreateDTO::fromRequest($request));
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = $this->productService->findById($id);
            return new ProductResource($product);
        } catch (\Throwable) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->updateById($product->id, ProductUpdateDTO::fromRequest($request));
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->deleteById($id);
        return response()->json(status: 201);
    }
}
