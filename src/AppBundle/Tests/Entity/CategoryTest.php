<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Category;
use AppBundle\Entity\Item;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category Entity Test
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty Category entity
     */
    public function testEmptyCategory()
    {
        $category = new Category();
        $this->assertEquals('New Category', $category->__toString());
        $this->assertNull($category->getId());
        $this->assertNull($category->getTitle());
        $this->assertEquals(0, $category->getItems()->count());
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $category->getItems());
        $this->assertNull($category->getCreatedAt());
        $this->assertNull($category->getUpdatedAt());
    }

    /**
     * Test setter and getter for title
     */
    public function testSetGetTitle()
    {
        $title = 'Title';
        $category = (new Category())->setTitle($title);
        $this->assertEquals($title, $category->getTitle());
    }

    /**
     * Test setter and getter for items
     */
    public function testSetGetItems()
    {
        $items = new ArrayCollection();
        $items->add(new Item());
        $country = (new Category())->setItems($items);
        $this->assertEquals(1, $country->getItems()->count());
        $this->assertEquals($items, $country->getItems());
    }

    /**
     * Test add and remove item
     */
    public function testAddRemoveItem()
    {
        $country = new Category();
        $this->assertEquals(0, $country->getItems()->count());

        $country->addItem(new Item());
        $this->assertEquals(1, $country->getItems()->count());

        $item = $country->getItems()->first();
        $country->removeItem($item);
        $this->assertEquals(0, $country->getItems()->count());
    }

    /**
     * Test setter and getter for createdAt
     */
    public function testSetGetCreatedAt()
    {
        $now = new \DateTime();
        $category = (new Category())->setCreatedAt($now);
        $this->assertEquals($now, $category->getCreatedAt());
    }

    /**
     * Test setter and getter for updatedAt
     */
    public function testSetGetUpdatedAt()
    {
        $now = new \DateTime();
        $category = (new Category())->setUpdatedAt($now);
        $this->assertEquals($now, $category->getUpdatedAt());
    }
}
