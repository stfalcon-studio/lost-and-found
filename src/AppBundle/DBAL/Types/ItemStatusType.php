<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * ItemStatusType type
 *
 * @author Artem Genvald <GenvaldArtem@gmail.com>
 * @author Yuri Svatok   <Svatok13@gmail.com>
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
