<?php


namespace AppBundle\Tests\Entity;

use AppBundle\Entity\UserItemRequest;
use AppBundle\Entity\User;
use AppBundle\Entity\Item;

/**
 * Class UserItemRequestTest
 *
 */
class UserItemRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test empty UserItemRequest
     */
    public function testEmptyUserItemRequest()
    {
        $userItemRequest = new UserItemRequest();
        $this->assertNull($userItemRequest->getId());
        $this->assertNull($userItemRequest->getUser());
        $this->assertNull($userItemRequest->getCreatedAt());
        $this->assertNull($userItemRequest->getUpdatedAt());
        $this->assertNull($userItemRequest->getItem());
    }

    /**
     *  Test User getter and setter
     */
    public function testSetGetUser()
    {
        $user = new User();
        $userItemRequest = ((new UserItemRequest())->setUser($user));
        $this->assertEquals($user, $userItemRequest->getUser());
    }

    /**
     *  Test Item getter and setter
     */
    public function testSetGetItem()
    {
        $item = new Item();
        $userItemRequest = ((new UserItemRequest())->setItem($item));
        $this->assertEquals($item, $userItemRequest->getItem());
    }

    /**
     *  Test CreatedAt getter and setter
     */
    public function testSetGetCreatedAt()
    {
        $date = new \DateTime('now');
        $userItemRequest = ((new UserItemRequest())->setCreatedAt($date));
        $this->assertEquals($date, $userItemRequest->getCreatedAt());
    }

    /**
     *  Test UpdatedAt getter and setter
     */
    public function testSetGetUpdatedAt()
    {
        $date = new \DateTime('now');
        $userItemRequest = ((new UserItemRequest())->setUpdatedAt($date));
        $this->assertEquals($date, $userItemRequest->getUpdatedAt());
    }
}
