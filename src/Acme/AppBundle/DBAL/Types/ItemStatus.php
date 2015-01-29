<?php
namespace Acme\AppBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;
/**
 * Class StatusType
 * @package Acme\AppBundle\DBAL\Types
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