<?php

namespace App\Contracts\Services;

use App\DataTransferObjects\Product\ProductCreateDTO;
use App\DataTransferObjects\Product\ProductUpdateDTO;

interface ProductServiceInterface
{
    public function paginate(int $currentPage, int $perPage = 10, string $search = null);

    public function findById(int $id);

    public function create(ProductCreateDTO $productCreateDTO);

    public function updateById(int $id, ProductUpdateDTO $productUpdateDTO);

    public function deleteById(int $id);
}
