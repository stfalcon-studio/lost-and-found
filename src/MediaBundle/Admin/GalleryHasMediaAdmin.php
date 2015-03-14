<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MediaBundle\Admin;

use Sonata\MediaBundle\Admin\GalleryHasMediaAdmin as SonataGalleryHasMediaAdmin;

/**
 * GalleryHasMediaAdmin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class GalleryHasMediaAdmin extends SonataGalleryHasMediaAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'media/gallery_has_media';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_gallery_has_media';
}
