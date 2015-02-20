<?php

namespace AppBundle\Event;

use AppBundle\Entity\Item;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewItemAddedEvent
 *
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 */
class NewItemAddedEvent extends Event
{
    /**
     * @var Item $item Item
     */
    private $item;

    /**
     * Constructor
     *
     * @param Item $item Item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get user
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
}
