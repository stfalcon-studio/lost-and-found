<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Category;
use AppBundle\Entity\Item;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\File;

/**
 * Category Entity Test
 *
 * @author Artem Genvald <GenvaldArtem@gmail.com>
 * @author Yuri Svatok   <Svatok13@gmail.com>
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

    /**
     * Test setter and getter for enabled
     */
    public function testSetGetEnabled()
    {
        $enabled = false;
        $category = (new Category())->setEnabled($enabled);
        $this->assertEquals($enabled, $category->isEnabled());
    }

    /**
     * Test setter and getter for imageName
     */
    public function testSetGetImageName()
    {
        $imageName = 'name';
        $category = (new Category())->setImageName($imageName);
        $this->assertEquals($imageName, $category->getImageName());
    }

    /**
     * Test setter and getter for imageFile
     */
    public function testSetGetImageFile()
    {
        $now = new \DateTime();
        $file = new File();
        $category = (new Category())->setImageFile($file);
        $this->assertEquals($now, $category->getUpdatedAt());
        $this->assertEquals($file, $category->getImageFile());
    }

    /**
     * Test setter and getter for parent
     */
    public function testSetGetParent()
    {
        $parent = (new Category())->setTitle('parent');
        $category = (new Category())->setParent($parent);
        $this->assertEquals($parent, $category->getParent());
    }

    /**
     * Test setter and getter for path
     */
    public function testSetGetPath()
    {
        $path = 'path';
        $category = (new Category())->setPath($path);
        $this->assertEquals($path, $category->getPath());
    }

    /**
     * Test setter and getter for level
     */
    public function testSetGetLevel()
    {
        $level = 1;
        $category = (new Category())->setLevel($level);
        $this->assertEquals($level, $category->getLevel());
    }

    /**
     * Test setter and getter for level
     */
    public function testSetGetChildren()
    {
        $child =(new Category())->setTitle('child');
        $category = (new Category())->setChildren($child);
        $this->assertEquals($child, $category->getChildren());
    }

    /**
     * Test setter and getter for path source
     */
    public function testSetGetPathSource()
    {
        $pathSource = 'pathSource';
        $category = (new Category())->setPathSource($pathSource);
        $this->assertEquals($pathSource, $category->getPathSource());
    }
}
