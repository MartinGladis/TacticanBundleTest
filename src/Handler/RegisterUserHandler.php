<?php

namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Repository\UserRepository;
use App\Service\MailSender;
use App\Service\UserFactory;

class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private MailSender $mailSender,
        private UserFactory $userFactory,
    ) {}

    public function handle(RegisterUserCommand $command)
    {
        $user = $this->userFactory->create(
            $command->getUuid(),
            $command->getEmail(),
            $command->getPlainPassword()
        );

        $this->userRepository->save($user, true);
        $this->mailSender->registerConfirm($command->getEmail());
    }
}