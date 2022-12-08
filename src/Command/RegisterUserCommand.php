<?php

namespace App\Command;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Uuid;

class RegisterUserCommand
{
    public function __construct(
        private string $uuid,

        #[Assert\Email(message: 'Email is not correct')]
        private string $email,
        
        #[Assert\Length(min: 3, minMessage: 'Passwort must be at least {{ limit }} characters long')]
        private string $plainPassword
    ) {}

    public function getUuid(): string
    {
        return $this->uuid;
    }

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
        $uuid = Uuid::uuid4();

        return new static($uuid, $content["email"], $content["password"]);
    }
}