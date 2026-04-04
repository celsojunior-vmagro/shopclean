<?php

namespace App\Domain\UseCases;

use App\Application\DTOs\CreateProductInput;
use App\Application\DTOs\CreateProductOutput;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepository;

readonly class CreateProductUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    )
    {
    }

    public function execute(CreateProductInput $input): CreateProductOutput
    {
        $product = Product::create(
            $input->name,
            $input->description,
            $input->price,
            $input->stock,
        );

        $saved = $this->productRepository->save($product);

        return new CreateProductOutput(
            id: $saved->getId(),
            name: $saved->getName(),
            description: $saved->getDescription(),
            price: $saved->getPrice(),
            stock: $saved->getStock(),
        );
    }
}
