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
 * UserActionType type
 *
 * @author Yuri Svatok <svatok13@gmail.com>
 */
class UserActionType extends AbstractEnumType
{
    const CONNECT     = 'connect';
    const LOGIN       = 'login';
    const DEAUTHORIZE = 'deauthorize';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::CONNECT     => 'Connect user',
        self::LOGIN       => 'Login user',
        self::DEAUTHORIZE => 'Deauthorize user',
    ];
}
