<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category Entity
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @Vich\Uploadable
 * @ORM\Table(name="categories")
 *
 * @Gedmo\Loggable
 */
class Category
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int $id ID
     */
    private $id;

    /**
     * @var string $title Title
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Gedmo\Versioned
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(min="1", max="255")
     */
    private $title;

    /**
     * @var Collection|Item[] $items Items
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="category", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $items;

    /**
     * @var boolean $enabled Enabled
     *
     * @ORM\Column(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $enabled = false;

    /**
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="imageName")
     *
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * __toString method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?: 'New Category';
    }

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
     * Get title
     *
     * @return string Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title Title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get items
     *
     * @return Item[]|Collection Items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set items
     *
     * @param Item[]|Collection $items Items
     *
     * @return $this
     */
    public function setItems(Collection $items)
    {
        foreach ($items as $item) {
            $item->setCategory($this);
        }
        $this->items = $items;

        return $this;
    }

    /**
     * Add item
     *
     * @param Item $item Item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items->add($item->setCategory($this));

        return $this;
    }

    /**
     * Remove item
     *
     * @param Item $item Item
     *
     * @return $this
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    /**
     * Is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled Enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

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
