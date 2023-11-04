<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface;
use App\DataTransferObjects\Product\ProductCreateDTO;
use App\DataTransferObjects\Product\ProductUpdateDTO;

class ProductService implements ProductServiceInterface
{

    public function paginate(int $currentPage, int $perPage = 10, string $search = null)
    {
        return [];
    }

    public function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    public function create(ProductCreateDTO $productCreateDTO)
    {
        // TODO: Implement create() method.
    }

    public function updateById(int $id, ProductUpdateDTO $productUpdateDTO) {
        // TODO: Implement updateById() method.
    }

    public function deleteById(int $id)
    {
        // TODO: Implement deleteById() method.
    }
}
