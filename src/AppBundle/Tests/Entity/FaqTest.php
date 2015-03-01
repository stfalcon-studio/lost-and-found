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

use AppBundle\Entity\Faq;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Translation\FaqTranslation;

/**
 * FAQ Entity Test
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
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

    /**
     * Test setter and getter for locale
     */
    public function testSetGetLocale()
    {
        $locale = 'en';
        $faq = (new Faq())->setLocale($locale);
        $this->assertEquals($locale, $faq->getLocale());
    }

    /**
     * Test setter and getter for translation
     */
    public function testSetGetTranslation()
    {
        $tr = new ArrayCollection();
        $tr->add(new FaqTranslation());
        $faq = (new Faq())->setTranslations($tr);
        $this->assertEquals(1, $faq->getTranslations()->count());
        $this->assertEquals($tr, $faq->getTranslations());
    }

    /**
     * Test add and remove translation
     */
    public function testAddRemoveTranslation()
    {
        $faq = new Faq();
        $this->assertEquals(0, $faq->getTranslations()->count());

        $faq->addTranslation(new FaqTranslation());
        $this->assertEquals(1, $faq->getTranslations()->count());

        $tr = $faq->getTranslations()->first();
        $faq->removeTranslation($tr);
        $this->assertEquals(0, $faq->getTranslations()->count());
    }
}
