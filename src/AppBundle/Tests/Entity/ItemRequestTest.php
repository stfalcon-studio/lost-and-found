<?php


namespace AppBundle\Tests\Entity;

use AppBundle\Entity\ItemRequest;
use AppBundle\Entity\User;
use AppBundle\Entity\Item;

/**
 * UserActionLog Entity Test
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
 */
class ItemRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test empty UserItemRequest
     */
    public function testEmptyUserItemRequest()
    {
        $userItemRequest = new ItemRequest();
        $this->assertNull($userItemRequest->getId());
        $this->assertNull($userItemRequest->getUser());
        $this->assertNull($userItemRequest->getCreatedAt());
        $this->assertNull($userItemRequest->getItem());
    }

    /**
     * Test User getter and setter
     */
    public function testSetGetUser()
    {
        $user = new User();
        $userItemRequest = ((new ItemRequest())->setUser($user));
        $this->assertEquals($user, $userItemRequest->getUser());
    }

    /**
     * Test Item getter and setter
     */
    public function testSetGetItem()
    {
        $item = new Item();
        $userItemRequest = ((new ItemRequest())->setItem($item));
        $this->assertEquals($item, $userItemRequest->getItem());
    }

    /**
     * Test CreatedAt getter and setter
     */
    public function testSetGetCreatedAt()
    {
        $date = new \DateTime('now');
        $userItemRequest = ((new ItemRequest())->setCreatedAt($date));
        $this->assertEquals($date, $userItemRequest->getCreatedAt());
    }
}
