<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ItemPhoto Entity
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="item_photos")
 *
 * @Vich\Uploadable
 */
class ItemPhoto
{
    use TimestampableEntity;

    /**
     * @var int $id ID
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Item $item Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="photos")
     *
     * @ORM\JoinColumn(name="item", referencedColumnName="id")
     */
    private $item;

    /**
     * @var File $imageFile Image file
     * @Assert\Image(
     *      minWidth = 50,
     *      maxWidth = 1920,
     *      minHeight = 50,
     *      maxHeight = 1080
     * )
     * @Vich\UploadableField(mapping="item_photos", fileNameProperty="imageName", nullable=true)
     */
    private $imageFile;

    /**
     * @var string $imageName Image name
     *
     * @ORM\Column(type="string", length=255, name="image_name", nullable=true)
     */
    private $imageName;

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
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
     * @param Item $item Item
     *
     * @return $this
     */
    public function setItem(Item $item)
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

        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     *
     * @return $this
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }
}
