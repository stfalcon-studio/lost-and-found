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
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Entity\UserActionLog;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User Entity Test
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty User entity
     */
    public function testEmptyUser()
    {
        $user = new User();
        $this->assertEquals('New User', $user->__toString());
        $this->assertNull($user->getId());
        $this->assertNull($user->getFullName());
        $this->assertNull($user->getFacebookAccessToken());
        $this->assertNull($user->getFacebookId());
        $this->assertEquals(0, $user->getItems()->count());
    }

    /**
     * Test setter and getter for Full Name
     */
    public function testSetGetFullName()
    {
        $fullName = 'Some Name';
        $user     = (new User())->setFullName($fullName);
        $this->assertEquals($fullName, $user->getFullName());
    }

    /**
     * Test setter and getter for Item
     */
    public function testSetGetItem()
    {
        $items = new ArrayCollection();
        $items->add(new Item());
        $user = (new User())->setItems($items);
        $this->assertEquals(1, $user->getItems()->count());
        $this->assertEquals($items, $user->getItems());
    }

    /**
     * Test setter and getter for facebook id
     */
    public function testSetGetFacebookId()
    {
        $faceId = '123321';
        $user   = (new User())->setFacebookId($faceId);
        $this->assertEquals($faceId, $user->getFacebookId());
    }

    /**
     * Test setter and getter for facebook access token
     */
    public function testSetGetFacebookAccessToken()
    {
        $faceAccessToken = '123321';
        $user            = (new User())->setFacebookAccessToken($faceAccessToken);
        $this->assertEquals($faceAccessToken, $user->getFacebookAccessToken());
    }

    /**
     * Test add and remove for item
     */
    public function testAddRemoveItem()
    {
        $user = new User();
        $this->assertEquals(0, $user->getItems()->count());
        $user->addItem(new Item());
        $this->assertEquals(1, $user->getItems()->count());
        $item = $user->getItems()->first();
        $user->removeItem($item);
        $this->assertEquals(0, $user->getItems()->count());
    }

    /**
     * Test Action log getter and setter
     */
    public function testSetGetActionLog()
    {
        $arr = [
            'log1' => new UserActionLog(),
            'log2' => new UserActionLog(),
        ];
        $collection = new ArrayCollection($arr);
        $user       = ((new User())->setActionLogs($collection));
        $this->assertEquals($collection, $user->getActionLogs());
    }

    /**
     * Test add and remove for actionLog
     */
    public function testAddRemoveActionLog()
    {
        $user = new User();
        $this->assertEquals(0, $user->getActionLogs()->count());
        $user->addActionLog(new UserActionLog());
        $this->assertEquals(1, $user->getActionLogs()->count());
        $actionLog = $user->getActionLogs()->first();
        $user->removeActionLog($actionLog);
        $this->assertEquals(0, $user->getActionLogs()->count());
    }

    /**
     * Test setter and getter userRequests
     */
    public function testSetGetUserRequests()
    {
        $arr        = [
            'log1' => new ItemRequest(),
            'log2' => new ItemRequest(),
        ];
        $collection = new ArrayCollection($arr);
        $user = (new User())->setUserRequests($collection);
        $this->assertEquals($collection, $user->getItemRequests());
    }

    /**
     * Test add and remove user Request
     */
    public function testAddRemoveUserRequest()
    {
        $user = (new User())->addUserRequest(new ItemRequest());
        $this->assertEquals(1, $user->getItemRequests()->count());
        $userRequest = $user->getItemRequests()->first();
        $user->removeUserRequest($userRequest);
        $this->assertEquals(0, $user->getItemRequests()->count());
    }

    /**
     * Test set and get receive message
     */
    public function testSetGetReceiveMessage()
    {
        $message = new Message();
        $user = (new User())->setReceiveMessages($message);
        $this->assertEquals($message, $user->getReceiveMessages());
    }

    /**
     * Test set and get sent message
     */
    public function testSetGetSendMessage()
    {
        $message = new Message();
        $user = (new User())->setSentMessages($message);
        $this->assertEquals($message, $user->getSentMessages());
    }
}
