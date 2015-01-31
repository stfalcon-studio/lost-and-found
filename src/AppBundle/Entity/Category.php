<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Category Entity
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="categories")
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
}
