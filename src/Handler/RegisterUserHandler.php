<?php

namespace App\Handler;

use App\Command\RegisterUserCommand;
use App\Repository\UserRepository;
use App\Service\MailSender;
use App\Service\UserFactory;
use Ramsey\Uuid\Uuid;

class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private MailSender $mailSender,
        private UserFactory $userFactory,
    ) {}

    public function handle(RegisterUserCommand $command)
    {
        $uuid = Uuid::uuid4();
        $user = $this->userFactory->create(
            $uuid,
            $command->getEmail(),
            $command->getPlainPassword()
        );

        $this->userRepository->save($user, true);
        $this->mailSender->registerConfirm($command->getEmail());
    }
}