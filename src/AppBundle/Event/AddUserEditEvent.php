<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Event;

use AppBundle\Entity\Item;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
     * Get token storage
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
