<?php
namespace Acme\AppBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class BasketballPositionType
 * @package Acme\AppBundle\DBAL\Types
 */
class ItemType extends AbstractEnumType
{
    const LOST  = 'lost';
    const FOUND = 'found';

    protected static $choices = [
        self::LOST  => 'Lost Item',
        self::FOUND => 'Found Item',
    ];
}