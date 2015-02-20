<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * ItemAreaType type
 *
 * @author Artem Genvald  <GenvaldArtem@gmail.com>
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
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
        self::MARKER    => 'Marker'
    ];
}
