<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
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
    const FACEBOOK_USER_CONNECTED = 'app.facebook_user_connected';
    const NEW_ITEM_ADDED = 'app.new_item_added';
}
