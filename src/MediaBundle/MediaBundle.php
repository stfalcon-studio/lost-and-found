<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * MediaBundle
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class MediaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'CoopTilleulsCKEditorSonataMediaBundle';
    }
}
