<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserFactory
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function create(string $uuid, string $email, string $plainPassword)
    {
        $user = new User(
            $uuid,
            $email
        );

        $password = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);

        return $user;
    }
}