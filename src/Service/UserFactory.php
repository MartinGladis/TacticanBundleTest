<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;


class UserFactory
{
    private PasswordHasherInterface $passwordHasher;

    public function __construct(PasswordHasherFactoryInterface $factory) {
        $this->passwordHasher = $factory->getPasswordHasher(User::class);
    }

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