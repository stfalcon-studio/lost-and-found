<?php

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
