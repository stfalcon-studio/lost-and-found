<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\Collection;
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
    protected $items;

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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Add item
     *
     * @param Item $items
     *
     * @return Category
     */
    public function addItems(Item $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Get item
     *
     * @return Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set item
     *
     * @param Item $item
     *
     * @return $this
     */
    public function setItem($item)
    {
        $this->items = $item;

        return $this;
    }
}
