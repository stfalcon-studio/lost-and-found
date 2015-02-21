<?php

namespace AppBundle\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * CategoryAdminController
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
 */
class CategoryAdminController extends CRUDController
{
    /**
     * Mark categories as enabled
     *
     * @return RedirectResponse
     */
    public function batchActionEnableAction()
    {
        return $this->commonBatchWork(true, 'Enabled successfully');
    }

    /**
     * Mark categories as disabled
     *
     * @return RedirectResponse
     */
    public function batchActionDisableAction()
    {
        return $this->commonBatchWork(false, 'Disabled successfully');
    }

    /**
     * Common batch work
     *
     * @param boolean $enabled           Enabled
     * @param string  $successfulMessage Successful message
     *
     * @return RedirectResponse
     */
    private function commonBatchWork($enabled, $successfulMessage)
    {
        $em = $this->getDoctrine()->getManager();

        $categoryIds = $this->get('request')->get('idx', []);

        if (count($categoryIds)) {
            $categoryRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Category[] $categories */
            $categories = $categoryRepository->findBy(['id' => $categoryIds]);

            foreach ($categories as $category) {
                $category->setEnabled($enabled);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', $successfulMessage);

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
