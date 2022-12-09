<?php

namespace App\Tests\Fixtures;
use App\Service\MailSenderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class FakeMailSender implements MailSenderInterface
{
    public Collection $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function registerConfirm(string $emailAddress): void
    {
        $this->messages->add($emailAddress);
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }
}