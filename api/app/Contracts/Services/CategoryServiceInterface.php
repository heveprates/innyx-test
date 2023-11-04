<?php

namespace App\Contracts\Services;

use App\DataTransferObjects\Category\CategoryCreateDTO;
use App\DataTransferObjects\Category\CategoryUpdateDTO;

interface CategoryServiceInterface
{
    public function paginate(int $currentPage, int $perPage = 10, string $search = null);

    public function all();

    public function findById(int $id);

    public function create(CategoryCreateDTO $productCreateDTO);

    public function updateById(int $id, CategoryUpdateDTO $productUpdateDTO);

    public function deleteById(int $id);
}
