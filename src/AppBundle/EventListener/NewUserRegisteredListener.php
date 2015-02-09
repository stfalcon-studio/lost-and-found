<?php

namespace AppBundle\EventListener;

use AppBundle\Event\NewUserRegisteredEvent;
use FOS\UserBundle\Mailer\Mailer;
use Swift_Mailer;

/**
 * FacebookUserConnectedListener
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class NewUserRegisteredListener
{
    /**
     * @var Mailer $mailer Mailer
     */
    private $mailer;

    /**
     * @param Swift_Mailer $mailer Mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param NewUserRegisteredEvent $args
     */
    public function sendEmailNotification(NewUserRegisteredEvent $args)
    {
        $user = $args->getUser();

        $message = $this->mailer
            ->createMessage()
            ->setSubject('You have Completed Registration!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo($user->getEmail())
            ->setBody('Blabla');

        $this->mailer
            ->send($message);
    }
}