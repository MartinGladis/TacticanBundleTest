<?php

namespace App\Service;

use App\Entity\User;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFactory
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function create($username, $password)
    {
        $user = new User(
            Uuid::uuid4(),
            $username
        );

        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        return $user;
    }
}