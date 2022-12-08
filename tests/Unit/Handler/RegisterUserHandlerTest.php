<?php

namespace App\Tests\Unit\Handler;

use App\Command\RegisterUserCommand;
use App\Entity\User;
use App\Handler\RegisterUserHandler;
use App\Repository\UserRepository;
use App\Service\MailSenderInterface;
use App\Service\UserFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

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
            ->with($this->isType('string'), 'some@example.mail', 'examplePassword')
            ->willReturn($user);

        
        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->expects($this->once())
            ->method('save')
            ->with($user);

        $mailSender = $this->createMock(MailSenderInterface::class);
        $mailSender->expects($this->once())
            ->method('registerConfirm')
            ->with('some@example.mail');

        $handler = new RegisterUserHandler(
            $userRepository,
            $mailSender,
            $userFactory
        );

        $command = new RegisterUserCommand(
            Uuid::uuid4(),
            'some@example.mail',
            'examplePassword'
        );

        $handler->handle($command);
    }
}
