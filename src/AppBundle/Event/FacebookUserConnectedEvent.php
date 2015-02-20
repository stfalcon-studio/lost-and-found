<?php

namespace AppBundle\Event;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * FacebookUserConnectedEvent
 *
 * @author Artem Genvald <GenvaldArtem@gmail.com>
 */
class FacebookUserConnectedEvent extends Event
{
    /**
     * @var User $user User
     */
    private $user;

    /**
     * Constructor
     *
     * @param User $user User
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
