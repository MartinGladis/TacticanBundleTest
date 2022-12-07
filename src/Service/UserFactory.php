<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;


class UserFactory
{
    public function __construct(
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function create(string $uuid, string $email, string $plainPassword)
    {
        $password = $this->passwordHasher->hash($plainPassword);

        $user = new User(
            $uuid,
            $email,
            $password
        );

        return $user;
    }
}