<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventListener;

use AppBundle\Event\NewItemAddedEvent;
use Swift_Mailer;

/**
 * NewItemAddedListener
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
 */
class NewItemAddedListener
{
    /**
     * @var Swift_Mailer $mailer Mailer
     */
    private $mailer;

    /**
     * @var array $adminEmails Admin emails
     */
    private $adminEmails;

    /**
     * Constructor
     *
     * @param Swift_Mailer $mailer      Mailer
     * @param array        $adminEmails Admin emails
     */
    public function __construct(Swift_Mailer $mailer, array $adminEmails)
    {
        $this->mailer      = $mailer;
        $this->adminEmails = $adminEmails;
    }

    /**
     * @param NewItemAddedEvent $args
     */
    public function onItemAdded(NewItemAddedEvent $args)
    {
        $message = $this->mailer
            ->createMessage()
            ->setSubject('Hey admin! User added new item!')
            ->setFrom('logansoleg@gmail.com')
            ->setTo($this->adminEmails)
            ->setBody('Bla bla..');

        $this->mailer->send($message);
    }
}
