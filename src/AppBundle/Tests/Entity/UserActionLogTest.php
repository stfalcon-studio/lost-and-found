<?php


namespace AppBundle\Tests\Entity;

use AppBundle\Entity\UserActionLog;
use AppBundle\DBAL\Types\UserActionType;
use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class UserActionLogTest
 *
 */
class UserActionLogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test empty user log
     */
    public function testEmptyUserLog()
    {
        $userActionLog = new UserActionLog();
        $this->assertNull($userActionLog->getId());
        $this->assertNull($userActionLog->getActionType());
        $this->assertNull($userActionLog->getUser());
        $this->assertNull($userActionLog->getCreatedAt());
        $this->assertNull($userActionLog->getUpdatedAt());
    }

    /**
     * Test ActionType getter and setter
     */
    public function testSetGetActionType()
    {
        $type = UserActionType::CONNECT;
        $userActionLog = ((new UserActionLog())->setActionType($type));
        $this->assertEquals($type, $userActionLog->getActionType());
    }

    /**
     *  Test User getter and setter
     */
    public function testSetGetUser()
    {
        $user = new User();
        $userActionLog = ((new UserActionLog())->setUser($user));
        $this->assertEquals($user, $userActionLog->getUser());
    }

    /**
     *  Test CreatedAt getter and setter
     */
    public function testSetGetCreatedAt()
    {
        $date = new \DateTime('now');
        $userActionLog = ((new UserActionLog())->setCreatedAt($date));
        $this->assertEquals($date, $userActionLog->getCreatedAt());
    }

    /**
     *  Test UpdatedAt getter and setter
     */
    public function testSetGetUpdatedAt()
    {
        $date = new \DateTime('now');
        $userActionLog = ((new UserActionLog())->setUpdatedAt($date));
        $this->assertEquals($date, $userActionLog->getUpdatedAt());
    }
}
