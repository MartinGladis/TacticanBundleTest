<?php

namespace App\Service;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailSender
{
    public function __construct(
        private MailerInterface $mailer
    ) {}

    public function registerConfirm(string $emailAddress)
    {
        $email = (new Email())
            ->from(new Address('wodoted152@ceoshub.com', 'Confirm'))
            ->to('martin@katosoftwarehouse.pl')
            ->subject('Registration Confirm')
            ->html("<h1>Confirm</h1>");
        
        $this->mailer->send($email);
    }
}