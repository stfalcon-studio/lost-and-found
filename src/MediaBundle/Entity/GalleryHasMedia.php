<?php

namespace MediaBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGalleryHasMedia as BaseGalleryHasMedia;

/**
 * GalleryHasMedia Entity Class
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class GalleryHasMedia extends BaseGalleryHasMedia
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
