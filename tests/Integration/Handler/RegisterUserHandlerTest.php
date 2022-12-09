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
     * @dataProvider userDataProvider
     */
    public function itShouldSaveUserToDb($email, $plainPassword): void 
    {

        $handler = $this->container->get(RegisterUserHandler::class);

        $uuid = Uuid::uuid4();
        $command = new RegisterUserCommand(
            $uuid,
            $email,
            $plainPassword
        );

        $handler->handle($command);

        $user = $this->userRepository->findOneBy(['email' => $email]);

        $this->assertEquals($email, $user->getEmail());
    }

    /**
     * @test
     * @group integrationHandler
     * @dataProvider userDataProvider
     */
    public function itShouldEmailSend($email, $plainPassword)
    {
        $mailSender = $this->container->get(MailSenderInterface::class);

        $mailSender->registerConfirm($email);

        $this->assertEquals($email, $mailSender->getMessages()->last());
    }

    public function userDataProvider(): array
    {
        return [
            [
                'email' => 'marta@outlook.com',
                'plainPassword' => 'qwerty'
            ],
            [
                'email' => 'andrzej@gmail.com',
                'plainPassword' => '12345'
            ]
        ];
    }
}