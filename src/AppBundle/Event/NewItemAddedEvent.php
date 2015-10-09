<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Event;

use AppBundle\Entity\Item;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewItemAddedEvent
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
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
