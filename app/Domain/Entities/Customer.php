<?php

namespace App\Domain\Entities;

class Customer
{
    private function __construct(
        private readonly ?string $id,
        private string           $name,
        private string           $email,
        private string           $cpf
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('O nome é obrigatório');
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('O e-mail deve ser válido');
        }

        if (!preg_match('/^\d{11}$/', $this->cpf)) {
            throw new \InvalidArgumentException('O CPF deve conter exatamente 11 dígitos numéricos.');
        }
    }

    public static function create(
        string $name,
        string $email,
        string $cpf
    ): self
    {
        return new self(null, $name, $email, $cpf);
    }

    public static function reconstitute(
        string $id,
        string $name,
        string $email,
        string $cpf
    ): self
    {
        return new self($id, $name, $email, $cpf);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCPF(): string
    {
        return $this->cpf;
    }
}
