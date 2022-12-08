<?php

namespace App\Service;

class TestMailSender implements MailSenderInterface
{
    public function registerConfirm(string $emailAddress): void
    {
        var_dump("TEST");
    }
}