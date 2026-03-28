<?php

namespace App\Domain\Entities;

class Order
{
    private function __construct(
        private readonly ?string $id,
        private readonly string  $customerId,
        private array            $items,
        private string           $status,
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->customerId)) {
            throw new \InvalidArgumentException('O pedido deve estar associado a um cliente.');
        }
    }

    public static function reconstitute(
        string $id,
        string $customerId,
        array  $items,
        string $status
    ): self
    {
        return new self($id, $customerId, $items, $status);
    }

    public static function create(
        string $customerId,
    ): self
    {
        return new self(null, $customerId, [], 'pending');
    }

    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;
    }

    public function confirm(): void
    {
        if (empty($this->items)) {
            throw new \DomainException('É obrigatório ter item do pedido');
        }

        $this->status = 'confirmed';
    }

    public function cancel(): void
    {
        if ($this->status === 'confirmed') {
            throw new \DomainException('Não é possível cancelar o pedido pois ele já foi confirmado');
        }

        $this->status = 'cancelled';
    }

    public function getTotal(): float
    {
        return array_sum(
            array_map(fn(OrderItem $item) => $item->getSubtotal(), $this->items)
        );
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
