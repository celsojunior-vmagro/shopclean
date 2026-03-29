<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Customer;

interface CustomerRepository
{
    public function findById(string $id): ?Customer;

    public function findByEmail(string $email): ?Customer;

    public function findAll(): array;

    public function save(Customer $customer): Customer;

    public function delete(string $id): void;
}
