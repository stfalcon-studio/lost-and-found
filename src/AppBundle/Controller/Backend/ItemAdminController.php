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
    public function batchActionMarkAsModerated()
    {
        $items = $this->getRequest()->get('idx', []);

        $em = $this->getDoctrine()->getManager();

        if (count($items)) {
            $itemRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Item $item */
            foreach ($itemRepository->findBy(['id' => $items]) as $item) {
                $item->setModerated(true);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', 'Moderation was marked successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * Unmark items as moderated
     *
     * @return RedirectResponse
     */
    public function batchActionUnmarkAsModerated()
    {
        $items = $this->getRequest()->get('idx', []);

        $em = $this->getDoctrine()->getManager();

        if (count($items)) {
            $itemRepository = $em->getRepository($this->admin->getClass());

            /** @var \AppBundle\Entity\Item $item */
            foreach ($itemRepository->findBy(['id' => $items]) as $item) {
                $item->setModerated(false);
            }

            $em->flush();
        }

        $this->addFlash('sonata_flash_success', 'Moderation was unmarked successfully');

        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
