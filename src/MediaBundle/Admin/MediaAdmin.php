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

use Sonata\MediaBundle\Admin\ORM\MediaAdmin as SonataMediaAdmin;

/**
 * MediaAdmin
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class MediaAdmin extends SonataMediaAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'media/media';

    /**
     * {@inheritdoc}
     */
    protected $baseRouteName = 'admin_media';
}
