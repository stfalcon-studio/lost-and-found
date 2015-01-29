<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Item status type
 *
 * @author Logans <LogansOleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemStatusType extends AbstractEnumType
{
    const ACTIVE   = 'active';
    const RESOLVED = 'resolved';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::ACTIVE   => 'Active',
        self::RESOLVED => 'Resolved'
    ];
}
