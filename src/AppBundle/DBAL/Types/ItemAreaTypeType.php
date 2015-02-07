<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Item type
 *
 * @author Logans <LogansOleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemAreaTypeType extends AbstractEnumType
{
    const POLYGON  = 'polygon';
    const RECTANGLE = 'rectangle';
    const CIRCLE = 'circle';
    const MARKER = 'marker';

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
