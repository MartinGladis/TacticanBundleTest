<?php

namespace App\Command;

class RegisterUserCommand
{
    public function __construct(
        private string $email,
        private string $plainPassword
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}