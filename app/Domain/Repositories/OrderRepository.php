<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Order;

interface OrderRepository
{
    public function findById(string $id): ?Order;

    public function findByCustomerId(string $customerId): array;

    public function save(Order $order): Order;
}
