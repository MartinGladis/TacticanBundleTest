<?php

namespace App\Tests\Unit\Service;

use App\Service\MailSender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailSenderTest extends TestCase
{
    /**
     * @test
     * @group email
     * @dataProvider emailAddressDataProvider
     */
    public function itShouldSendConfirmEmail(string $emailAddress): void
    {
        $email = (new Email())
            ->from(new Address('confirm@register.com', 'Confirm'))
            ->to($emailAddress)
            ->subject('Registration Confirm')
            ->html("<h1>Confirm</h1>");

        $mailerMock = $this->createMock(MailerInterface::class);
        $mailerMock->expects($this->once())
            ->method('send')
            ->with($this->equalTo($email));

        $mailSender = new MailSender($mailerMock);
        $mailSender->registerConfirm($emailAddress);
    }

    public function emailAddressDataProvider(): array
    {
        return [
            ['email@mail.com'],
            ['marysia@outlook.com']
        ];
    }
}
