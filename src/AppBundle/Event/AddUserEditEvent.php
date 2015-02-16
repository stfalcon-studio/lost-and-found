<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Model\UserManageableInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use AppBundle\Entity\Item;

/**
 * Class Add User Edit Event
 *
 * @package AppBundle\Event
 */
class AddUserEditEvent extends Event
{

    /**
    * @var TokenStorageInterface $tokenStorage Token storage
    */
    private $tokenStorage;

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @var Item $item
     */
    private $item;

    /**
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param Item                  $item
     */
    public function __construct(TokenStorageInterface $tokenStorage, Item $item)
    {
        $this->tokenStorage = $tokenStorage;
        $this->item = $item;
    }
}
