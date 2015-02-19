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

        $adminEmails = $this->container->getParameter('admin_emails');

        $message = $this->mailer
            ->createMessage()
            ->setSubject('Hey admin! Users added new item!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo($adminEmails)
            ->setBody('Blabla');

        $this->mailer->send($message);
    }
}
