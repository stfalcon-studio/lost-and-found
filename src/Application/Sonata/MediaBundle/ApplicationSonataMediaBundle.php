<?php

namespace Application\Sonata\MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Application Sonata Media Bundle
 */
class ApplicationSonataMediaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'CoopTilleulsCKEditorSonataMediaBundle';
    }
}
