<?php

namespace App\Application\DTOs;

readonly class CreateCustomerInput
{
    public function __construct(
        public string $name,
        public string $email,
        public string $cpf,
    )
    {
    }
}
