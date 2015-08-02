<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * ItemAreaType type
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class ItemAreaTypeType extends AbstractEnumType
{
    const POLYGON   = 'polygon';
    const RECTANGLE = 'rectangle';
    const CIRCLE    = 'circle';
    const MARKER    = 'marker';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::POLYGON   => 'Polygon',
        self::RECTANGLE => 'Rectangle',
        self::CIRCLE    => 'Circle',
        self::MARKER    => 'Marker',
    ];
}
