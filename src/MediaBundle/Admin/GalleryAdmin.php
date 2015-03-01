<?php

namespace MediaBundle\Admin;

use Sonata\MediaBundle\Admin\GalleryAdmin as SonataGalleryAdmin;

/**
 * GalleryAdmin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class GalleryAdmin extends SonataGalleryAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'media/gallery';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_gallery';
}
