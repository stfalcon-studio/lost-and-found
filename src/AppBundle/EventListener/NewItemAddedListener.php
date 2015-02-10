<?php

namespace AppBundle\EventListener;

use AppBundle\Event\NewItemAddedEvent;
use Swift_Mailer;

/**
 * NewItemAddedListener
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class NewItemAddedListener
{
    /**
     * @var array $adminEmail Admin email
     */
    private $adminEmail = [
        /* TODO: Fill with admin emails */
    ];

    /**
     * @var Swift_Mailer $mailer Mailer
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
     * @param NewItemAddedEvent $args
     */
    public function onItemAdded(NewItemAddedEvent $args)
    {
        $item = $args;

        $message = $this->mailer
            ->createMessage()
            ->setSubject('You have Completed Registration!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo('Admin Email')
            ->setBody('Blabla');

        $this->mailer->send($message);
    }
}