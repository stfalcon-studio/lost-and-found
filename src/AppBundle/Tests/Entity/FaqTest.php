<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Faq;
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
        $faq = new Faq();
        $this->assertEquals('New Faq', $faq->__toString());
        $this->assertNull($faq->getId());
        $this->assertNull($faq->getQuestion());
        $this->assertNull($faq->getAnswer());
        $this->assertNull($faq->getCreatedAt());
        $this->assertNull($faq->getUpdatedAt());
    }

    /**
     * Test setter and getter for question
     */
    public function testSetGetQuestion()
    {
        $question = 'Some question?';
        $faq = (new Faq())->setQuestion($question);
        $this->assertEquals($question, $faq->getQuestion());
    }

    /**
     * Test setter and getter for answer
     */
    public function testSetGetAnswer()
    {
        $answer = 'Some answer!';
        $faq = (new Faq())->setAnswer($answer);
        $this->assertEquals($answer, $faq->getAnswer());
    }

    /**
     * Test setter and getter for created At
     */
    public function testSetGetCreatedAt()
    {
        $now = new \DateTime();
        $faq = (new Faq())->setCreatedAt($now);
        $this->assertEquals($now, $faq->getCreatedAt());
    }

    /**
     * Test setter and getter for updated At
     */
    public function testSetGetUpdatedAt()
    {
        $now = new \DateTime();
        $faq = (new Faq())->setUpdatedAt($now);
        $this->assertEquals($now, $faq->getUpdatedAt());
    }

    /**
     * Test setter and getter for enabled
     */
    public function testSetGetEnabled()
    {
        $enabled = false;
        $faq = (new Faq())->setEnabled($enabled);
        $this->assertEquals($enabled, $faq->isEnabled());
    }
}
