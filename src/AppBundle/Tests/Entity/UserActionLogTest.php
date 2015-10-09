<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Entity;

use AppBundle\DBAL\Types\UserActionType;
use AppBundle\Entity\User;
use AppBundle\Entity\UserActionLog;

/**
 * UserActionLog Entity Test
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
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
}
