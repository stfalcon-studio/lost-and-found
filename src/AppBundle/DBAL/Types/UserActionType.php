<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * UserActionType type
 *
 * @author Yuri Svatok <Svatok13@gmail.com>
 */
class UserActionType extends AbstractEnumType
{
    const CONNECT  = 'connect';
    const LOGIN = 'login';
    const DEAUTHORIZE = 'deauthorize';

    /**
     * {@inheritdoc}
     */
    protected static $choices = [
        self::CONNECT  => 'Connect user',
        self::LOGIN => 'Login user',
        self::DEAUTHORIZE => 'Deauthorize user',
    ];
}
