<?php

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
