<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Model\UserManageableInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\Item;

/**
 * Class Add User Edit Event
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class AddUserEditEvent extends Event
{
    /**
    * @var TokenStorageInterface $tokenStorage Token storage
    */
    private $tokenStorage;

    /**
     * @var Item $item Item
     */
    private $item;

    /**
     * @param TokenStorageInterface $tokenStorage Token storage
     * @param Item                  $item         Item
     */
    public function __construct(TokenStorageInterface $tokenStorage, Item $item)
    {
        $this->tokenStorage = $tokenStorage;
        $this->item         = $item;
    }

    /**
     * Get token stogare
     *
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
}
