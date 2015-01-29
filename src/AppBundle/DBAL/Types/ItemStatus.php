<?php
namespace AppBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class ItemStatus
 *
 * @author Logans <LogansOleg@gmail.com>
 */
class ItemStatus extends AbstractEnumType
{
    const ACTIVE = 'active';
    const DONE   = 'done';

    /**
     * @var array
     *
     * {@inheritDoc} Contains ENUM values for item status
     */
    protected static $choices = [
        self::ACTIVE => 'Active',
        self::DONE   => 'Done',
    ];
}