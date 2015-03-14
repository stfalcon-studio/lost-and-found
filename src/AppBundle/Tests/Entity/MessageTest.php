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

use AppBundle\Entity\Message;
use AppBundle\Entity\User;

/**
 * Message Test
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty Message entity
     */
    public function testEmptyMessage()
    {
        $message = new Message();
        $this->assertNull($message->getId());
        $this->assertNull($message->getContent());
        $this->assertTrue($message->isActive());
        $this->assertNull($message->getSender());
        $this->assertNull($message->getReceiver());
        $this->assertFalse($message->isDeleted());
    }

    /**
     * Test setter and getter for Content
     */
    public function testSetGetContent()
    {
        $id = '1';
        $message = (new Message())->setContent($id);
        $this->assertEquals($id, $message->getContent());
    }

    /**
     * Test setter and getter for Active
     */
    public function testSetGetActiveFalse()
    {
        $active = false;
        $message = (new Message())->setActive($active);
        $this->assertFalse($active, $message->isActive());
    }

    /**
     * Test setter and getter for Active
     */
    public function testSetGetActiveTrue()
    {
        $active = true;
        $message = (new Message())->setActive($active);
        $this->assertTrue($active, $message->isActive());
    }

    /**
     * Test setter and getter for Sender
     */
    public function testSetGetSender()
    {
        $user = new User();
        $message = (new Message())->setSender($user);
        $this->assertEquals($user, $message->getSender());
    }

    /**
     * Test setter and getter for Receiver
     */
    public function testSetGetReceiver()
    {
        $user = new User();
        $message = (new Message())->setReceiver($user);
        $this->assertEquals($user, $message->getReceiver());
    }

    /**
     * Test setter and getter for Deleted
     */
    public function testSetGetDeletedFalse()
    {
        $deleted = false;
        $message = (new Message())->setDeleted($deleted);
        $this->assertFalse($deleted, $message->isDeleted());
    }

    /**
     * Test setter and getter for Deleted
     */
    public function testSetGetDeletedTrue()
    {
        $deleted = true;
        $message = (new Message())->setDeleted($deleted);
        $this->assertTrue($deleted, $message->isDeleted());
    }
}
