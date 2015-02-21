<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * ItemStatusType type
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
 */
class ItemStatusType extends AbstractEnumType
{
    const ACTUAL   = 'actual';
    const RESOLVED = 'resolved';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::ACTUAL   => 'Actual',
        self::RESOLVED => 'Resolved'
    ];
}
