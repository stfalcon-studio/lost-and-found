<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Backend;

use A2lix\TranslationFormBundle\Annotation\GedmoTranslation;
use Sonata\AdminBundle\Controller\CRUDController;

/**
 * Backend BaseAdminController
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
