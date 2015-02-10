<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uploadable\Fixture\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class ItemPhoto
 * @ORM\Entity
 * @ORM\Table(name="item_photos")
 *
 * @Vich\Uploadable
 */

class ItemPhoto
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /**
     * @var File $imageFile
     *
     * @Vich\UploadableField(mapping="item_photos", fileNameProperty="fileName")
     */
    private $imageFile;

    /**
     * @var string $imageName
     * @ORM\Column(type="string", length=255, name="image_name", nullable=true)
     */
    private $imageName;

    /**
     * @var Item $item item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="photos")
     *
     * @ORM\JoinColumn(name="item", referencedColumnName="id")
     *
     */
    private $item;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fileName
     *
     * @param string $imageName
     *
*@return ItemPhoto
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Get item
     *
     * @return Item Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set item
     *
     * @param Item $item item
     *
     * @return $this
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     *
     * @return $this
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}