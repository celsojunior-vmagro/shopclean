<?php

namespace App\Domain\Entities;

class Product
{
    private function __construct(
        private readonly ?string $id,
        private string           $name,
        private string           $description,
        private float            $price,
        private int              $stock,
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Nome do produto é obrigatório');
        }

        if ($this->price <= 0) {
            throw new \InvalidArgumentException('Preço deve ser maior que zero.');
        }

        if ($this->stock < 0) {
            throw new \InvalidArgumentException('Estoque não pode ser negativo.');
        }
    }

    public static function create(
        string $name,
        string $description,
        float  $price,
        int    $stock,
    ): self
    {
        return new self(null, $name, $description, $price, $stock);
    }

    public static function reconstitute(
        string $id,
        string $name,
        string $description,
        float  $price,
        int    $stock,
    ): self
    {
        return new self($id, $name, $description, $price, $stock);
    }

    public function reduceStock(int $quantity): void
    {
        if (!$this->hasStock($quantity)) {
            throw new \DomainException('Produto sem estoque suficiente.');
        }

        $this->stock -= $quantity;
    }

    public function hasStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}
