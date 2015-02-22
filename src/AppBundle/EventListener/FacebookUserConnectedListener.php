<?php

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
     * @var array $adminFacebookIds Facebook IDs of admin users
     */
    private $adminFacebookIds = [
        910325255664546, // Artem Genvald
        749493721786885, // Oleg Kachinsky
        436078019878362, // Andrew Prohorovych
        802187576526450  // Yura Svatok
    ];

    /**
     * @var Swift_Mailer $mailer Mailer
     */
    private $mailer;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @param Swift_Mailer  $mailer Mailer
     * @param EntityManager $em     EntityManager
     */
    public function __construct(Swift_Mailer $mailer, EntityManager $em)
    {
        $this->mailer = $mailer;
        $this->entityManager = $em;
    }

    /**
     * Event call's when user registered
     *
     * @param FacebookUserConnectedEvent $args Arguments
     */
    public function onUserRegistered(FacebookUserConnectedEvent $args)
    {
        $user = $args->getUser();

        if (in_array($user->getUsername(), $this->adminFacebookIds)) {
            $user->addRole('ROLE_ADMIN');
        }

        $actionLog = new UserActionLog();
        $actionLog->setActionType(UserActionType::CONNECT);
        $actionLog->setUser($user);
        $actionLog->setCreatedAt(new \DateTime('now'));

        $em = $this->entityManager;
        $em->persist($actionLog);
        $em->flush();

        $message = $this->mailer
            ->createMessage()
            ->setSubject('You have Completed Registration!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo($user->getEmail())
            ->setBody('Blabla');

        $this->mailer->send($message);
    }
}
