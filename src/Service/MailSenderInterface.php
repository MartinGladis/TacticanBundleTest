<?php

namespace App\Service;

interface MailSenderInterface
{
    public function registerConfirm(string $emailAddress): void;
}