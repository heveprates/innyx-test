<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface;
use App\DataTransferObjects\Product\ProductCreateDTO;
use App\DataTransferObjects\Product\ProductUpdateDTO;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

class ProductService implements ProductServiceInterface
{

    public function __construct(
        private readonly Product $productModel
    ) {
    }

    public function paginate(int $currentPage, int $perPage = 12, string $search = null)
    {
        $query = $this->productModel->newQuery()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }
        return $query->paginate(perPage: $perPage, page: $currentPage);
    }

    public function findById(int $id): Product
    {
        return $this->productModel->newQuery()->findOrFail($id);
    }

    public function create(ProductCreateDTO $productCreateDTO)
    {
        $requestInput = [
            'name' => $productCreateDTO->name,
            'description' => $productCreateDTO->description,
            'price' => $productCreateDTO->price,
            'date_validity' => $productCreateDTO->dateValidity,
            'image' => $this->uploadImage($productCreateDTO->image),
            'category_id' => $productCreateDTO->categoryId,
        ];
        return $this->productModel->newQuery()->create($requestInput);
    }

    public function updateById(int $id, ProductUpdateDTO $productUpdateDTO)
    {
        $product = $this->findById($id);
        $requestInput = [];
        if ($productUpdateDTO->name !== null) {
            $requestInput['name'] = $productUpdateDTO->name;
        }
        if ($productUpdateDTO->description !== null) {
            $requestInput['description'] = $productUpdateDTO->description;
        }
        if ($productUpdateDTO->price !== null) {
            $requestInput['price'] = $productUpdateDTO->price;
        }
        if ($productUpdateDTO->dateValidity !== null) {
            $requestInput['date_validity'] = $productUpdateDTO->dateValidity;
        }
        if ($productUpdateDTO->image !== null) {
            $requestInput['image'] = $this->uploadImage($productUpdateDTO->image);
        }
        if ($productUpdateDTO->categoryId !== null) {
            $requestInput['category_id'] = $productUpdateDTO->categoryId;
        }
        return $product->update($requestInput);
    }

    public function deleteById(int $id)
    {
        $product = $this->findById($id);
        $product->delete();
    }

    private function uploadImage(UploadedFile $image): string
    {
        $publicPath = 'images/products';
        $fileName = $image->hashName();
        $image->move(public_path($publicPath), $fileName);
        return "$publicPath/$fileName";
    }
}
