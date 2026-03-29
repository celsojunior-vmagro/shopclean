<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

interface ProductRepository
{
    public function findById(string $id): ?Product;

    public function findAll(): array;

    public function save(Product $product): Product;

    public function delete(string $id): void;
}
