<?php

namespace AppBundle\EventListener;

use AppBundle\Event\FacebookUserConnectedEvent;

/**
 * FacebookUserConnectedListener
 *
 * Add ROLE_ADMIN for some Facebook users
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
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
     * Add admin role
     *
     * @param FacebookUserConnectedEvent $args Arguments
     */
    public function addAdminRole(FacebookUserConnectedEvent $args)
    {
        $user = $args->getUser();

        if (in_array($user->getUsername(), $this->adminFacebookIds)) {
            $user->addRole('ROLE_ADMIN');
        }
    }
}
