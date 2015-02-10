<?php

namespace AppBundle\EventListener;

use AppBundle\Event\FacebookUserConnectedEvent;
use FOS\UserBundle\Mailer\Mailer;
use Swift_Mailer;

/**
 * FacebookUserConnectedListener
 *
 * Add ROLE_ADMIN for some Facebook users
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Logans <Logansoleg@gmail.com>
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
     * @param Swift_Mailer $mailer Mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
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

        $message = $this->mailer
            ->createMessage()
            ->setSubject('You have Completed Registration!')
            ->setFrom('Logansoleg@gmail.com')
            ->setTo($user->getEmail())
            ->setBody('Blabla');

        $this->mailer->send($message);
    }
}
