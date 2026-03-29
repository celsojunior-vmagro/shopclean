<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    use HasUuids;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
        'id',
    ];

    protected $casts = [
        'unit_price' => 'float',
        'quantity' => 'integer',
    ];
}
