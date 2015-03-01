<?php

namespace MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGallery as BaseGallery;

/**
 * Gallery Entity Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class Gallery extends BaseGallery
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
}
