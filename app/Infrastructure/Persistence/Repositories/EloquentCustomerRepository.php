<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Customer;
use App\Domain\Repositories\CustomerRepository;
use App\Infrastructure\Persistence\Models\CustomerModel;
use Illuminate\Support\Str;

class EloquentCustomerRepository implements CustomerRepository
{

    public function findById(string $id): ?Customer
    {
        $model = CustomerModel::find($id);

        if (!$model) {
            return null;
        }

        return Customer::reconstitute(
            $model->id,
            $model->name,
            $model->email,
            $model->cpf,
        );
    }

    public function findByEmail(string $email): ?Customer
    {
        $model = CustomerModel::where('email', $email)->first();

        if (!$model) {
            return null;
        }

        return Customer::reconstitute(
            $model->id,
            $model->name,
            $model->email,
            $model->cpf,
        );
    }

    public function findAll(): array
    {
        return CustomerModel::all()
            ->map(fn(CustomerModel $model) => Customer::reconstitute(
                $model->id,
                $model->name,
                $model->email,
                $model->cpf,
            ))->toArray();
    }

    public function save(Customer $customer): Customer
    {
        $data = [
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'cpf' => $customer->getCPF(),
        ];

        if ($customer->getId()) {
            $model = CustomerModel::findOrFail($customer->getId());
            $model->update($data);
        } else {
            $id = (string)Str::uuid();
            $model = CustomerModel::create(['id' => $id, ...$data]);
        }

        return Customer::reconstitute(
            $model->id,
            $model->name,
            $model->email,
            $model->cpf,
        );
    }

    public function delete(string $id): void
    {
        CustomerModel::findOrFail($id)->delete();
    }
}
