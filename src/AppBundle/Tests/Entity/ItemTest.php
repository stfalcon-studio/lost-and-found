<?php

namespace AppBundle\Tests\Entity;

use AppBundle\DBAL\Types\ItemAreaTypeType;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\Category;
use AppBundle\Entity\Item;
use AppBundle\Entity\User;

/**
 * Class ItemTest
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty Item entity
     */
    public function testEmptyItem()
    {
        $item = new Item();
        $this->assertNull($item->getId());
        $this->assertEquals('New Item', $item->__toString());
        $this->assertNull($item->getTitle());
        $this->assertNull($item->getLatitude());
        $this->assertNull($item->getLongitude());
        $this->assertNull($item->getType());
        $this->assertNull($item->getDescription());
        $this->assertNull($item->getArea());
        $this->assertNull($item->getAreaType());
        $this->assertEquals(ItemStatusType::ACTUAL, $item->getStatus());
        $this->assertTrue($item->isActive());
        $this->assertNull($item->getDate());
        $this->assertNull($item->getCreatedBy());
        $this->assertFalse($item->isModerated());
        $this->assertNull($item->getModeratedAt());
    }

    /**
     * Test setter and getter for Category
     */
    public function testSetGetCategory()
    {
        $category = new Category();
        $item = (new Item())->setCategory($category);
        $this->assertEquals($category, $item->getCategory());
    }

    /**
     * Test setter and getter for Title
     */
    public function testSetGetTitle()
    {
        $title = 'Title';
        $item = (new Item())->setTitle($title);
        $this->assertEquals($title, $item->getTitle());
    }

    /**
     * Test setter and getter for Latitude
     */
    public function testSetGetLatitude()
    {
        $latitude = 55.555555555;
        $item = (new Item())->setLatitude($latitude);
        $this->assertEquals($latitude, $item->getLatitude());
    }

    /**
     * Test setter and getter for Longitude
     */
    public function testSetGetLongitude()
    {
        $longitude = 77.777777777;
        $item = (new Item())->setLongitude($longitude);
        $this->assertEquals($longitude, $item->getLongitude());
    }

    /**
     * Test setter and getter for Type
     */
    public function testSetGetType()
    {
        $type = ItemTypeType::LOST;
        $item = (new Item())->setType($type);
        $this->assertEquals($type, $item->getType());
    }

    /**
     * Test setter and getter for Description
     */
    public function testSetGetDescription()
    {
        $description = 'Description';
        $item = (new Item())->setDescription($description);
        $this->assertEquals($description, $item->getDescription());
    }

    /**
     * Test setter and getter for Area
     */
    public function testSetGetArea()
    {
        $area = array(
            'a' => 1,
            'b' => 2,
        );

        $item = (new Item())->setArea($area);
        $this->assertEquals($area, $item->getArea());
    }

    /**
     * Test setter and getter for AreaType
     */
    public function testSetGetAreaType()
    {
        $areaType = ItemAreaTypeType::MARKER;
        $item = (new Item())->setAreaType($areaType);
        $this->assertEquals($areaType, $item->getAreaType());
    }

    /**
     * Test setter and getter for Status
     */
    public function testSetGetStatus()
    {
        $status = ItemStatusType::ACTUAL;
        $item = (new Item())->setStatus($status);
        $this->assertEquals($status, $item->getStatus());
    }

    /**
     * Test setter and getter for Active
     */
    public function testSetGetActive()
    {
        $active = false;
        $item = (new Item())->setActive($active);
        $this->assertEquals($active, $item->isActive());
    }

    /**
     * Test setter and getter for Date
     */
    public function testSetGetDate()
    {
        $date = new \DateTime();
        $item = (new Item())->setDate($date);
        $this->assertEquals($date, $item->getDate());
    }

    /**
     * Test setter and getter for CreatedBy
     */
    public function testSetGetCreatedBy()
    {
        $createdBy = new User();
        $item = (new Item())->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $item->getCreatedBy());
    }

    /**
     * Test setter and getter for Moderated
     */
    public function testSetGetModerated()
    {
        $moderated = true;
        $item = (new Item())->setModerated($moderated);
        $this->assertEquals($moderated, $item->isModerated());
    }

    /**
     * Test setter and getter for ModeratedAt
     */
    public function testSetGetModeratedAt()
    {
        $moderatedAt = new \DateTime();
        $item = (new Item())->setModeratedAt($moderatedAt);
        $this->assertEquals($moderatedAt, $item->getModeratedAt());
    }

    /**
     * Test post moderate method
     */
    public function testPostModerate()
    {
        /* TODO: Test for post moderate method */
    }
}
