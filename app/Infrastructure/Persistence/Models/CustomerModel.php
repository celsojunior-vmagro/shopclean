<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasUuids;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'cpf'
    ];
}
