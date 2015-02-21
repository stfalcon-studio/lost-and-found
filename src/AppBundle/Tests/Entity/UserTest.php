<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Item;
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
        $arr        = [
            'log1' => new UserActionLog(),
            'log2' => new UserActionLog()
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
}
