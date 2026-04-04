<?php

namespace App\Application\DTOs;

readonly class CreateCustomerOutput
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $cpf,
    )
    {
    }
}
