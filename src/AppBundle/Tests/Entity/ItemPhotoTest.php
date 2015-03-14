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

use AppBundle\Entity\Item;
use AppBundle\Entity\ItemPhoto;
use Symfony\Component\Validator\Constraints\File;
use Uploadable\Fixture\Entity\Image;

/**
 * ItemPhoto entity test
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class ItemPhotoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test an empty ItemPhoto Entity
     */
    public function testEmptyItemPhoto()
    {
        $itemPhoto = new ItemPhoto();
        $this->assertNull($itemPhoto->getId());
        $this->assertNull($itemPhoto->getImageName());
        $this->assertNull($itemPhoto->getItem());
        $this->assertNull($itemPhoto->getImageFile());
    }

    /**
     * Test for set and get item
     */
    public function testSetGetItem()
    {
        $item = new Item();
        $itemPhoto = (new ItemPhoto())->setItem($item);
        $this->assertEquals($item, $itemPhoto->getItem());
    }

    /**
     * Test for set and get imageName
     */
    public function testSetGetImageName()
    {
        $imageName = 'Phone-icon.png';
        $itemPhoto = (new ItemPhoto())->setImageName($imageName);
        $this->assertEquals($imageName, $itemPhoto->getImageName());
    }

    /**
     * Test for set and get imageFile
     */
    public function testSetGetImageFile()
    {
        $imageFile = new File();
        $itemPhoto = (new ItemPhoto())->setImageFile($imageFile);
        $this->assertEquals($imageFile, $itemPhoto->getImageFile());
    }
}
