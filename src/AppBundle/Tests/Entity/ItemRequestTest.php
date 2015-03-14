<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Item;
use AppBundle\Entity\ItemRequest;
use AppBundle\Entity\User;

/**
 * ItemRequest Entity Test
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
 */
class ItemRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test empty ItemRequest
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
        $itemRequest = ((new ItemRequest())->setUser($user));
        $this->assertEquals($user, $itemRequest->getUser());
    }

    /**
     * Test Item getter and setter
     */
    public function testSetGetItem()
    {
        $item = new Item();
        $itemRequest = ((new ItemRequest())->setItem($item));
        $this->assertEquals($item, $itemRequest->getItem());
    }

    /**
     * Test CreatedAt getter and setter
     */
    public function testSetGetCreatedAt()
    {
        $date = new \DateTime('now');
        $itemRequest = ((new ItemRequest())->setCreatedAt($date));
        $this->assertEquals($date, $itemRequest->getCreatedAt());
    }
}
