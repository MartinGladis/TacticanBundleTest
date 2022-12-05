<?php

namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function handle(RegisterUserCommand $command)
    {
        $user = new User();
        $user->setEmail($command->getEmail());
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $command->getPlainPassword())
        );

        $this->userRepository->save($user, true);
    }
}