<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventListener;

use AppBundle\Event\FacebookUserConnectedEvent;
use Swift_Mailer;
use AppBundle\Entity\UserActionLog;
use AppBundle\DBAL\Types\UserActionType;
use Doctrine\ORM\EntityManager;

/**
 * FacebookUserConnectedListener
 *
 * Add ROLE_ADMIN for some Facebook users
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Yuri Svatok    <svatok13@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class FacebookUserConnectedListener
{
    /**
     * @var Swift_Mailer $mailer Mailer
     */
    private $mailer;

    /**
     * @var EntityManager $entityManager Entity manager
     */
    private $entityManager;

    /**
     * @var string $mailerSender Mailer sender
     */
    private $mailerSender;

    /**
     * Constructor
     *
     * @param Swift_Mailer  $mailer       Mailer
     * @param EntityManager $em           EntityManager
     * @param string        $mailerSender Mailer sender
     */
    public function __construct(Swift_Mailer $mailer, EntityManager $em, $mailerSender)
    {
        $this->mailer        = $mailer;
        $this->entityManager = $em;
        $this->mailerSender  = $mailerSender;
    }

    /**
     * Event is called when user has been registered
     *
     * @param FacebookUserConnectedEvent $args Arguments
     */
    public function onUserRegistered(FacebookUserConnectedEvent $args)
    {
        $user = $args->getUser();

        $actionLog = (new UserActionLog())
            ->setUser($user)
            ->setActionType(UserActionType::CONNECT);

        $this->entityManager->persist($actionLog);
        $this->entityManager->flush();

        $message = $this->mailer
            ->createMessage()
            ->setSubject('You have completed registration on "Lost and Found"')
            ->setFrom($this->mailerSender)
            ->setTo($user->getEmail())
            ->setBody('Have a nice day! :)');

        $this->mailer->send($message);
    }
}
