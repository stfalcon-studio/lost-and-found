<?php
namespace Acme\AppBundle\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class ItemType
 *
 * @author Logans <LogansOleg@gmail.com>
 */
class ItemType extends AbstractEnumType
{
    const LOST  = 'lost';
    const FOUND = 'found';

    /**
     * @var array
     *
     * {@inheritDoc} Contains ENUM values for item type
     */
    protected static $choices = [
        self::LOST  => 'Lost Item',
        self::FOUND => 'Found Item',
    ];
}