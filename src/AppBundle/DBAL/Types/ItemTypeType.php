<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Item type
 *
 * @author Logans <LogansOleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemTypeType extends AbstractEnumType
{
    const LOST  = 'lost';
    const FOUND = 'found';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::LOST  => 'Lost Item',
        self::FOUND => 'Found Item'
    ];
}
