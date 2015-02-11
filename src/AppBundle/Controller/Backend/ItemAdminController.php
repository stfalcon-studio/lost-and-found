<?php

namespace AppBundle\Controller\Backend;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * ItemAdminController
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemAdminController extends CRUDController
{
    /**
     * Mark items as moderated
     *
     * @return RedirectResponse
     */
    public function batchActionMarkAsModeratedAction()
    {
        return $this->commonBatchWork(true, 'Moderation was marked successfully');
    }

    /**
     * Unmark items as moderated
     *
     * @return RedirectResponse
     */
    public function batchActionUnmarkAsModeratedAction()
    {
        return $this->commonBatchWork(false, 'Moderation was unmarked successfully');
    }

    /**
     * Common batch work
     *
     * @param boolean $moderated         Moderated
     * @param string  $successfulMessage Successful message
     *
     * @return RedirectResponse
     */
    private function commonBatchWork($moderated, $successfulMessage)
    {
        $em = $this->getDoctrine()->getManager();

        $itemIds = $this->getRequest()->get('idx', []);

        if (count($itemIds)) {
            $itemRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Item[] $items */
            $items = $itemRepository->findBy(['id' => $itemIds]);

            foreach ($items as $item) {
                $item->setModerated($moderated);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', $successfulMessage);

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
