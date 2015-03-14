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
 * ItemTypeType type
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class ItemTypeType extends AbstractEnumType
{
    const LOST  = 'lost';
    const FOUND = 'found';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::LOST  => 'Lost item',
        self::FOUND => 'Found item'
    ];
}
