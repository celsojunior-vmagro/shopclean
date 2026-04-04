<?php

namespace App\Application\DTOs;

readonly class CreateProductInput
{
    public function __construct(
        public string $name,
        public string $description,
        public float  $price,
        public int    $stock,
    )
    {
    }
}
