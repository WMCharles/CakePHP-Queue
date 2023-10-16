<?php

declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Queue\Mailer\QueueTrait;

/**
 * Notify mailer.
 */
class NotifyMailer extends Mailer
{
    use QueueTrait;
    public static $name = 'Notify';

    public function notify(string $emailAddress, string $username): void
    {
        $this
            ->setTo($emailAddress)
            ->setSubject(sprintf('Welcome %s', $username));
    }
}
