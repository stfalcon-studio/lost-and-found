<?php
namespace AppBundle\Tests\Entity;
use AppBundle\Entity\User;
use AppBundle\Entity\Item;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Class UserTest
 *
 * @author Prohorovych Andrew <prohorovychua@gmail.com>
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function emptyUser()
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
     *
     * @test
     */
    public function setGetFullName()
    {
        $fullName = 'Some Name';
        $user = (new User())->setFullName($fullName);
        $this->assertEquals($fullName, $user->getFullName());
    }
    /**
     * Test setter and getter for Item
     *
     * @test
     */
    public function setGetItem()
    {
        $items = new ArrayCollection();
        $items->add(new Item());
        $user = (new User())->setItems($items);
        $this->assertEquals(1, $user->getItems()->count());
        $this->assertEquals($items, $user->getItems());
    }
    /**
     * Test setter and getter for facebook id
     *
     * @test
     */
    public function setGetFacebookId()
    {
        $faceId = '123321';
        $user = (new User())->setFacebookId($faceId);
        $this->assertEquals($faceId, $user->getFacebookId());
    }
    /**
     * Test setter and getter for facebook access token
     *
     * @test
     */
    public function setGetFacebookAccessToken()
    {
        $faceAccessToken = '123321';
        $user = (new User())->setFacebookAccessToken($faceAccessToken);
        $this->assertEquals($faceAccessToken, $user->getFacebookAccessToken());
    }
    /**
     * Test add and remove for item
     *
     * @test
     */
    public function addRemoveItem()
    {
        $user = new User();
        $this->assertEquals(0, $user->getItems()->count());
        $user->addItem(new Item());
        $this->assertEquals(1, $user->getItems()->count());
        $item = $user->getItems()->first();
        $user->removeItem($item);
        $this->assertEquals(0, $user->getItems()->count());
    }
}