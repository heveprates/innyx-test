<?php

namespace App\Services;

use App\Contracts\Services\CategoryServiceInterface;
use App\DataTransferObjects\Category\CategoryCreateDTO;
use App\DataTransferObjects\Category\CategoryUpdateDTO;
use App\Models\Category;

class CategoryService implements CategoryServiceInterface
{

    public function __construct(
        private readonly Category $categoryModel
    ) {
    }
    public function paginate(int $currentPage, int $perPage = 12, string $search = null)
    {
        $query = $this->categoryModel->newQuery()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        return $query->paginate(perPage: $perPage, page: $currentPage);
    }

    public function findById(int $id): Category
    {
        return $this->categoryModel->newQuery()->findOrFail($id);
    }

    public function create(CategoryCreateDTO $categoryCreateDTO)
    {
        $requestInput = [
            'name' => $categoryCreateDTO->name,
        ];
        return $this->categoryModel->newQuery()->create($requestInput);
    }

    public function updateById(int $id, CategoryUpdateDTO $categoryUpdateDTO)
    {
        $category = $this->findById($id);
        $requestInput = [];
        if ($categoryUpdateDTO->name !== null) {
            $requestInput['name'] = $categoryUpdateDTO->name;
        }
        return $category->update($requestInput);
    }

    public function deleteById(int $id)
    {
        $category = $this->findById($id);
        return $category->delete();
    }

    public function all()
    {
        return $this->categoryModel->newQuery()
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }
}
