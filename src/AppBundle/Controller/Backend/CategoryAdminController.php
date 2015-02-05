<?php

namespace AppBundle\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * CategoryAdminController
 *
 * @author svatok13
 */
class CategoryAdminController extends CRUDController
{
    /**
     * Mark categories as enabled
     *
     * @return RedirectResponse
     */
    public function batchActionMarkAsEnabled()
    {
        $categories = $this->getRequest()->get('idx', []);

        $em = $this->getDoctrine()->getManager();

        if (count($categories)) {
            $categoryRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Category $category */
            foreach ($categoryRepository->findBy(['id' => $categories]) as $category) {
                $category->setEnabled(true);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', 'Enabled was marked successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * Unmark categories as enabled
     *
     * @return RedirectResponse
     */
    public function batchActionUnmarkAsEnabled()
    {
        $categories = $this->getRequest()->get('idx', []);

        $em = $this->getDoctrine()->getManager();

        if (count($categories)) {
            $categoryRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Category $category */
            foreach ($categoryRepository->findBy(['id' => $categories]) as $category) {
                $category->setEnabled(false);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', 'Enabled was unmarked successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
