<?php

namespace App\Service;

use App\Entity\User;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UserFactory
{

    private UserPasswordHasherInterface $passwordHasher;

    private ValidatorInterface $validator;

    public function __construct(UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator)
    {
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
    }

    public function create($email, $plainPassword)
    {
        $user = new User(
            Uuid::uuid4(),
            $email,
            $plainPassword
        );

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            throw new \Exception($errors->get(0)->getMessage());
        }

        $user->eraseCredentials();
        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

        return $user;
    }
}