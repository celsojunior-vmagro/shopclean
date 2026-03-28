<?php

namespace App\Domain\Entities;

readonly class OrderItem
{
    private function __construct(
        private ?string $id,
        private string  $productId,
        private string  $productName,
        private float   $unitPrice,
        private int     $quantity,
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->quantity <= 0) {
            throw new \InvalidArgumentException('A quantidade deve ser maior que zero');
        }

        if ($this->unitPrice <= 0) {
            throw new \InvalidArgumentException('O Preço deve ser maior que zero');
        }
    }

    public static function create
    (
        string $productId,
        string $productName,
        float  $unitPrice,
        int    $quantity,
    ): self
    {
        return new self(null, $productId, $productName, $unitPrice, $quantity);
    }

    public static function reconstitute(
        string $id,
        string $productId,
        string $productName,
        float  $unitPrice,
        int    $quantity
    ): self
    {
        return new self($id, $productId, $productName, $unitPrice, $quantity);
    }

    public function getSubtotal(): float
    {
        return $this->unitPrice * $this->quantity;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
