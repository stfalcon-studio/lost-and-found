<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\FAQ;
use Symfony\Component\Validator\Constraints\File;

/**
 * Test for FAQ Entity
 */
class FAQTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty FAQ entity
     */
    public function testEmptyFAQ()
    {
        $FAQ = new FAQ();
        $this->assertEquals('New FAQ', $FAQ->__toString());
        $this->assertNull($FAQ->getId());
        $this->assertNull($FAQ->getQuestion());
        $this->assertNull($FAQ->getAnswer());
        $this->assertNull($FAQ->getCreatedAt());
        $this->assertNull($FAQ->getUpdatedAt());
    }

    /**
     * Test setter and getter for question
     */
    public function testSetGetQuestion()
    {
        $question = 'Some question?';
        $FAQ = (new FAQ())->setQuestion($question);
        $this->assertEquals($question, $FAQ->getQuestion());
    }

    /**
     * Test setter and getter for answer
     */
    public function testSetGetAnswer()
    {
        $answer = 'Some answer!';
        $FAQ = (new FAQ())->setAnswer($answer);
        $this->assertEquals($answer, $FAQ->getAnswer());
    }

    /**
     * Test setter and getter for createdAt
     */
    public function testSetGetCreatedAt()
    {
        $now = new \DateTime();
        $FAQ = (new FAQ())->setCreatedAt($now);
        $this->assertEquals($now, $FAQ->getCreatedAt());
    }

    /**
     * Test setter and getter for updatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $now = new \DateTime();
        $FAQ = (new FAQ())->setUpdatedAt($now);
        $this->assertEquals($now, $FAQ->getUpdatedAt());
    }
}
