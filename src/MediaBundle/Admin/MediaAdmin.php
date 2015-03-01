<?php

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
