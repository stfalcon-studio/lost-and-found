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

/**
 * AppEvents
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
final class AppEvents
{
    /**
     * This event is triggered when a new user has been registered through the Facebook application
     *
     * Listeners receive an instance of AppBundle\Event\FacebookUserConnectedEvent
     */
    const FACEBOOK_USER_CONNECTED = 'app.facebook_user_connected';

    /**
     * This event is triggered when a new item has been added
     *
     * Listeners receive an instance of AppBundle\Event\NewItemAddedEvent
     */
    const NEW_ITEM_ADDED = 'app.new_item_added';
}
