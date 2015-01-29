<?php
namespace Acme\AppBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class ItemStatus
 *
 * @author Logans <LogansOleg@gmail.com>
 *
 * {@inheritDoc} Contains ENUM values for item status
 */
class ItemStatus extends AbstractEnumType
{
    const ACTIVE = 'active';
    const DONE   = 'done';

    protected static $choices = [
        self::ACTIVE => 'Active',
        self::DONE   => 'Done',
    ];
}