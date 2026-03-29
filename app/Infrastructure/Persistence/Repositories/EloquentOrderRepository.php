<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Order;
use App\Domain\Entities\OrderItem;
use App\Domain\Repositories\OrderRepository;
use App\Infrastructure\Persistence\Models\OrderModel;
use Illuminate\Support\Str;

class EloquentOrderRepository implements OrderRepository
{

    public function findById(string $id): ?Order
    {
        $model = OrderModel::with('items')->find($id);

        if (!$model) {
            return null;
        }

        $items = $model->items->map(fn($item) => OrderItem::reconstitute(
            $item->id,
            $item->product_id,
            $item->product_name,
            $item->unit_price,
            $item->quantity,
        ))->toArray();

        return Order::reconstitute($model->id, $model->customer_id, $items, $model->status);
    }

    public function findByCustomerId(string $customerId): array
    {
        $models = OrderModel::with('items')
            ->where('customer_id', $customerId)
            ->get();

        if ($models->isEmpty()) {
            return [];
        }

        return $models->map(function ($model) {
            $items = $model->items->map(function ($item) {
                return OrderItem::reconstitute(
                    $item->id,
                    $item->product_id,
                    $item->product_name,
                    $item->unit_price,
                    $item->quantity,
                );
            })->toArray();

            return Order::reconstitute($model->id, $model->customer_id, $items, $model->status);
        })->toArray();
    }

    public function save(Order $order): Order
    {
        $data = [
            'customer_id' => $order->getCustomerId(),
            'status' => $order->getStatus(),
        ];

        if ($order->getId()) {
            $model = OrderModel::findOrFail($order->getId());
            $model->update($data);
        } else {
            $id = (string)Str::uuid();
            $model = OrderModel::create(['id' => $id, ...$data]);
        }

        $model->items()->delete();

        foreach ($order->getItems() as $item) {
            $model->items()->create([
                'id' => $item->getId() ?? (string)Str::uuid(),
                'product_id' => $item->getProductId(),
                'product_name' => $item->getProductName(),
                'unit_price' => $item->getUnitPrice(),
                'quantity' => $item->getQuantity(),
            ]);
        }

        $model->load('items');

        $items = $model->items->map(fn($item) => OrderItem::reconstitute(
            $item->id,
            $item->product_id,
            $item->product_name,
            $item->unit_price,
            $item->quantity,
        ))->toArray();

        return Order::reconstitute(
            $model->id,
            $model->customer_id,
            $items,
            $model->status,
        );
    }
}
