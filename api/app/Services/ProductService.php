<?php

namespace App\Services;

use App\Contracts\Services\ProductServiceInterface;
use Psr\Http\Message\UploadedFileInterface;

class ProductService implements ProductServiceInterface
{

    public function paginate(int $currentPage, int $perPage = 10, string $search = null)
    {
        // TODO: Implement paginate() method.
    }

    public function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    public function create(
        string $name,
        string $description,
        float $price,
        \DateTimeInterface $dateValidity,
        UploadedFileInterface $image,
        int $categoryId
    ) {
        // TODO: Implement create() method.
    }

    public function updateById(
        int $id,
        string $name = null,
        string $description = null,
        float $price = null,
        \DateTimeInterface $dateValidity = null,
        UploadedFileInterface $image = null,
        int $categoryId = null,
    ) {
        // TODO: Implement updateById() method.
    }

    public function deleteById(int $id)
    {
        // TODO: Implement deleteById() method.
    }
}
