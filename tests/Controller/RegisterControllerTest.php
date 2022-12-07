<?php

namespace App\Tests\Controller;

use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    use ReloadDatabaseTrait;

    /**
     * @test
     * @dataProvider succesfullDataProvider
     */
    public function itShouldUserRegister(array $content): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/v1/register',
            content: json_encode($content)
        );

        $this->assertResponseIsSuccessful();
    }

    /**
     * @test
     * @dataProvider invalidEmailDataProvider
     */
    public function itShouldReturnInvalidEmailMessage(array $content): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/v1/register',
            content: json_encode($content)
        );

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals("Email is not correct", $responseContent["message"]);
    }

    /**
     * @test
     * @dataProvider invalidPasswordDataProvider
     */
    public function itShouldReturnInvalidPasswordMessage(array $content): void
    {
        $client = static::createClient();
        $client->request(
            method: 'POST',
            uri: '/api/v1/register',
            content: json_encode($content)
        );

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(400);
        $this->assertEquals("Passwort must be at least 3 characters long", $responseContent["message"]);
    }

    public function succesfullDataProvider(): array
    {
        return [
            [[
                "email" => "m@m.pl",
                "password" => "qwerty"
            ]],
            [[
                "email" => "magda@outlook.com",
                "password" => "rsbfvb"
            ]]
        ];
    }

    public function invalidEmailDataProvider(): array
    {
        return [
            [[
                "email" => "m@mpl",
                "password" => "qwerty"
            ]],
            [[
                "email" => "magdaoutlook.com",
                "password" => "rsbfvb"
            ]]
        ];
    }

    public function invalidPasswordDataProvider(): array
    {
        return [
            [[
                "email" => "m@m.pl",
                "password" => "q"
            ]],
            [[
                "email" => "magda@outlook.com",
                "password" => "er"
            ]]
        ];
    }
}
