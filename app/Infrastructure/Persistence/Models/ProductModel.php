<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasUuids;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
    ];
}
