<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
