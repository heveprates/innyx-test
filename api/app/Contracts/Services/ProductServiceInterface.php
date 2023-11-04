<?php

namespace App\Contracts\Services;

use Psr\Http\Message\UploadedFileInterface;

interface ProductServiceInterface
{
    public function paginate(int $currentPage, int $perPage = 10, string $search = null);

    public function findById(int $id);

    public function create(
        string $name,
        string $description,
        float $price,
        \DateTimeInterface $dateValidity,
        UploadedFileInterface $image,
        int $categoryId
    );

    public function updateById(
        int $id,
        string $name = null,
        string $description = null,
        float $price = null,
        \DateTimeInterface $dateValidity = null,
        UploadedFileInterface $image = null,
        int $categoryId = null,
    );

    public function deleteById(int $id);
}
