<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uploadable\Fixture\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class ItemPhoto
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="item_photos")
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
     * @var string $fileName
     * @ORM\Column(type="string", length=255, name="image_name", nullable=true)
     */
    private $fileName;

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
     * @param string $fileName
     * @return ItemPhoto
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
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