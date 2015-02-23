<?php

namespace AppBundle\EventListener;

use AppBundle\Event\NewItemAddedEvent;
use Swift_Mailer;

/**
 * NewItemAddedListener
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
 */
class NewItemAddedListener
{
    /**
     * @var array $adminEmails adminEmail Admin emails
     */
    private $adminEmails = [
        /* TODO: Fill with admin emeils */
        'genvaldartem@gmail.com', // Artem Genvald
        'logansoleg@gmail.com',   // Kachinsky Oleg
    ];

    /**
     * @var Swift_Mailer $mailer Mailer
     */
    private $mailer;

    /**
     * Constructor
     *
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
            ->setSubject('Hey admin! Users added new item!')
            ->setFrom('logansoleg@gmail.com')
            ->setTo($this->adminEmails)
            ->setBody('Bla bla..');

        $this->mailer->send($message);
    }
}
