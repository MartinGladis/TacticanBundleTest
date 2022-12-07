<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFactoryTest extends TestCase
{
    /**
     * @test
     * @group user
     * @dataProvider userDataProvider
     */
    public function itShouldCreateCorrectUser($uuid, $email, $plainPassword): void
    {
        $passwordHasherMock = $this->createMock(PasswordHasherInterface::class);

        $userFactory = new UserFactory($passwordHasherMock);
        $user = $userFactory->create($uuid, $email, $plainPassword);

        $expectUser = new User(
            $uuid,
            $email,
            $passwordHasherMock->hash($plainPassword)
        );

        $this->assertEquals($expectUser, $user);
    }

    public function userDataProvider(): array
    {
        return [
            [
                'uuid' => 'b27481a6-b15a-4e10-8b79-9e44c51f5575',
                'email' => 'marta@outlook.com',
                'plainPassword' => 'qwerty'
            ],
            [
                'uuid' => '2b9276a5-a884-4ac9-99e0-5c4b9ef1eef9',
                'email' => 'andrzej@gmail.com',
                'plainPassword' => '12345'
            ]
        ];
    }
}
