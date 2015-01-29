<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Item as Item;

/**
 * @ORM\Entity
 * @ORM\Table(name="Category")
 */
class Category
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int $id
     */
    protected $id;

    /**
     * @var string $title
     *
     * @ORM\Column(type="string",length=20)
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="category")
     */
    protected $item;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }
    
    public function __construct()
    {
        $this->item = new ArrayCollection();
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\Item $item
     * @return Category
     */
    public function addItem(Item $item)
    {
        $this->item[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\Item $item
     */
    public function removeItem(Item $item)
    {
        $this->item->removeElement($item);
    }

    /**
     * Get item
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set item
     *
     * @param Item $item
     * @return $this
     */
    public function setItem(Item $item)
    {
        $this->item = $item;

        return $this;
    }
}
