<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
