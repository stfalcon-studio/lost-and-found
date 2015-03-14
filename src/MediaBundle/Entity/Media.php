<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as BaseMedia;

/**
 * Media Entity Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Media extends BaseMedia
{
    /**
     * @var int $id ID
     */
    protected $id;

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName() ?: 'New Media File';
    }
}
