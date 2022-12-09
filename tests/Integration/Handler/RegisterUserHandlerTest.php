<?php

namespace App\Tests\Integration\Handler;
use App\Command\RegisterUserCommand;
use App\Handler\RegisterUserHandler;
use App\Repository\UserRepository;
use App\Service\MailSenderInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RegisterUserHandlerTest extends KernelTestCase
{
    use ReloadDatabaseTrait;

    private UserRepository $userRepository;

    private ContainerInterface $container;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->container = static::getContainer();
        $this->userRepository = $this->container->get(UserRepository::class);
    }

    /**
     * @test
     * @group integrationHandler
     */
    public function itShouldSaveUserToDb(): void 
    {
        $email = 'marta@outlook.com';
        $handler = $this->container->get(RegisterUserHandler::class);

        $uuid = Uuid::uuid4();
        $command = new RegisterUserCommand(
            $uuid,
            $email,
            'qwerty'
        );

        $handler->handle($command);
        $user = $this->userRepository->findOneBy(['email' => $email]);

        $this->assertEquals($email, $user->getEmail());

        $mailSender = $this->container->get(MailSenderInterface::class);
        $mailSender->registerConfirm($email);

        $this->assertEquals($email, $mailSender->getMessages()->last());
    }
}