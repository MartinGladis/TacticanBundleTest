<?php

namespace App\Command;
use Symfony\Component\HttpFoundation\Request;

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

    public static function fromRequest(Request $request): self
    {
        $content = json_decode($request->getContent(), true);

        return new static($content["email"], $content["password"]);
    }
}