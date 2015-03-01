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
