<?php

namespace App\Infrastructure\Providers;

use App\Domain\Repositories\CustomerRepository;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\ProductRepository;
use App\Infrastructure\Persistence\Repositories\EloquentCustomerRepository;
use App\Infrastructure\Persistence\Repositories\EloquentOrderRepository;
use App\Infrastructure\Persistence\Repositories\EloquentProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(CustomerRepository::class, EloquentCustomerRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
    }
}
