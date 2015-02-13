<?php

namespace AppBundle\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Faq Admin Controller
 */
class FaqAdminController extends CRUDController
{
    /**
     * Mark faq as enabled
     *
     * @return RedirectResponse
     */
    public function batchActionEnableAction()
    {
        return $this->commonBatchWork(true, 'Enabled successfully');
    }

    /**
     * Mark faq as disabled
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

        $faqIds = $this->getRequest()->get('idx', []);

        if (count($faqIds)) {
            $faqRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Faq[] $faq */
            $faq = $faqRepository->findBy(['id' => $faqIds]);

            foreach ($faq as $oneFaq) {
                $oneFaq->setEnabled($enabled);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', $successfulMessage);

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
