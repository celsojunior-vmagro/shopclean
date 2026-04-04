<?php

namespace App\Domain\UseCases;

use App\Application\DTOs\CreateCustomerInput;
use App\Application\DTOs\CreateCustomerOutput;
use App\Domain\Entities\Customer;
use App\Domain\Repositories\CustomerRepository;

readonly class CreateCustomerUseCase
{
    public function __construct(
        private CustomerRepository $customerRepository,
    )
    {
    }

    public function execute(CreateCustomerInput $input): CreateCustomerOutput
    {
        $existing = $this->customerRepository->findByEmail($input->email);

        if ($existing) {
            throw new \DomainException('Já existe um cliente com este e-mail.');
        }

        $customer = Customer::create(
            $input->name,
            $input->email,
            $input->cpf,
        );

        $saved = $this->customerRepository->save($customer);

        return new CreateCustomerOutput(
            id: $saved->getId(),
            name: $saved->getName(),
            email: $saved->getEmail(),
            cpf: $saved->getCPF(),
        );
    }
}
