<?php

namespace AppBundle\Controller\Backend;

use A2lix\TranslationFormBundle\Annotation\GedmoTranslation;
use Sonata\AdminBundle\Controller\CRUDController;

/**
 * BaseAdminController
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class BaseAdminController extends CRUDController
{
    /**
     * {@inheritdoc}
     *
     * @GedmoTranslation
     */
    public function editAction($id = null)
    {
        return parent::editAction($id);
    }
}
