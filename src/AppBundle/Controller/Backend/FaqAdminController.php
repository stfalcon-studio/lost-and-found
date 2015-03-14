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

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Backend FaqAdminController
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Artem Genvald      <genvaldartem@gmail.com>
 */
class FaqAdminController extends BaseAdminController
{
    /**
     * Mark F.A.Q. as enabled
     *
     * @return RedirectResponse
     */
    public function batchActionEnableAction()
    {
        return $this->commonBatchWork(true, 'Enabled successfully');
    }

    /**
     * Mark F.A.Q. as disabled
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

        $faqIds = $this->get('request')->get('idx', []);

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
