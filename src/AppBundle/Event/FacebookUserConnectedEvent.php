<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Event;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * FacebookUserConnectedEvent
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
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
