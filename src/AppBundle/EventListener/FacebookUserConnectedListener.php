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
     * @var array $adminFacebookIds Facebook IDs of admin users
     */
    private $adminFacebookIds;

    /**
     * Constructor
     *
     * @param Swift_Mailer  $mailer           Mailer
     * @param EntityManager $em               EntityManager
     * @param array         $adminFacebookIds Admin Facebook IDs
     */
    public function __construct(Swift_Mailer $mailer, EntityManager $em, array $adminFacebookIds)
    {
        $this->mailer           = $mailer;
        $this->entityManager    = $em;
        $this->adminFacebookIds = $adminFacebookIds;
    }

    /**
     * Event is called when user has been registered
     *
     * @param FacebookUserConnectedEvent $args Arguments
     */
    public function onUserRegistered(FacebookUserConnectedEvent $args)
    {
        $user = $args->getUser();

        if (in_array($user->getUsername(), $this->adminFacebookIds)) {
            $user->addRole('ROLE_ADMIN');
        }

        $actionLog = (new UserActionLog())
            ->setUser($user)
            ->setActionType(UserActionType::CONNECT);

        $this->entityManager->persist($actionLog);
        $this->entityManager->flush();

        $message = $this->mailer
            ->createMessage()
            ->setSubject('You have Completed Registration!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo($user->getEmail())
            ->setBody('Blabla');

        $this->mailer->send($message);
    }
}
