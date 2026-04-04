<?php

namespace App\Application\DTOs;

readonly class CreateProductOutput
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public float  $price,
        public int    $stock,
    )
    {
    }
}
