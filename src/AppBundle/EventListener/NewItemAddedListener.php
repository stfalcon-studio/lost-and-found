<?php

namespace AppBundle\EventListener;

use AppBundle\Event\NewItemAddedEvent;
use Swift_Mailer;

/**
 * NewItemAddedListener
 *
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 * @author Oleg Kachinsky     <LogansOleg@gmail.com>
 */
class NewItemAddedListener
{
    private $adminEmail = [
        /* TODO: Fill with admin emeils */
        'genvaldartem@gmail.com', //Artem Genvald
        'LogansOleg@gmail.com',   //Kachinsky Oleg
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
            ->setSubject('Hey admin! Users added new item!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo($this->adminEmail)
            ->setBody('Blabla');

        $this->mailer->send($message);
    }
}
