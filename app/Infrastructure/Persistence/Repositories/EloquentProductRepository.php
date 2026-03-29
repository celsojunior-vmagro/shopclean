<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepository;
use App\Infrastructure\Persistence\Models\ProductModel;
use Illuminate\Support\Str;

class EloquentProductRepository implements ProductRepository
{

    public function findById(string $id): ?Product
    {
        $model = ProductModel::find($id);

        if (!$model) {
            return null;
        }

        return Product::reconstitute(
            $model->id,
            $model->name,
            $model->description,
            $model->price,
            $model->stock,
        );
    }

    public function findAll(): array
    {
        return ProductModel::all()
            ->map(fn(ProductModel $model) => Product::reconstitute(
                $model->id,
                $model->name,
                $model->description,
                $model->price,
                $model->stock,
            ))->toArray();
    }

    public function save(Product $product): Product
    {
        $data = [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
        ];

        if ($product->getId()) {
            $model = ProductModel::findOrFail($product->getId());
            $model->update($data);
        } else {
            $id = (string)Str::uuid();
            $model = ProductModel::create(['id' => $id, ...$data]);
        }

        return Product::reconstitute(
            $model->id,
            $model->name,
            $model->description,
            $model->price,
            $model->stock,
        );
    }

    public function delete(string $id): void
    {
        ProductModel::findOrFail($id)->delete();
    }
}
