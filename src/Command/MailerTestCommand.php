<?php

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Mailer\MailerAwareTrait;

class MailerTestCommand extends Command
{
    use MailerAwareTrait;

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        /**
         * @var \App\Mailer\NotifyMailer $mailer
         */
        $mailer = $this->getMailer('Notify');

        $mailer->send('notify', ['wafulacharles47@gmail.com', 'Charles Wafula']);

        return static::CODE_SUCCESS;
    }
}
