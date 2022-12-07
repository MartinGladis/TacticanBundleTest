<?php

namespace App\Tests\Handler;

use App\Command\RegisterUserCommand;
use App\Entity\User;
use App\Handler\RegisterUserHandler;
use App\Repository\UserRepository;
use App\Service\MailSender;
use App\Service\UserFactory;
use PHPUnit\Framework\TestCase;

class RegisterUserHandlerTest extends TestCase
{
    /**
     * @test
     * @group handler
     */
    public function itShouldExecuteAllMethods(): void
    {
        $user = $this->createStub(User::class);

        $userFactory = $this->createMock(UserFactory::class);
        $userFactory->expects($this->once())
            ->method('create')
            ->with('uuid', 'some@example.mail', 'examplePassword')
            ->willReturn($user);

        
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('save')
            ->with($user);

        $mailSender = $this->createMock(MailSender::class);
        $mailSender->expects($this->once())
            ->method('registerConfirm')
            ->with('some@example.mail');

        $handler = new RegisterUserHandler(
            $userRepository,
            $mailSender,
            $userFactory
        );

        $command = $this->createStub(RegisterUserCommand::class);
        $command->method('getUuid')
            ->willReturn('uuid');
        $command->method('getEmail')
            ->willReturn('some@example.mail');
        $command->method('getPlainPassword')
            ->willReturn('examplePassword');

        $handler->handle($command);
    }
}
