<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DefaultController
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author svatok13
 */
class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @Route("/", name="homepage")
     *
     * @return array
     */
    public function indexAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getActiveFoundItem();
        $lostItems  = $itemRepository->getActiveLostItem();

        $foundPoints = $itemRepository->getFoundPoints();

        return $this->render('frontend/default/index.html.twig', [
            'found_items'  => $foundItems,
            'lost_items'   => $lostItems,
            'found_points' => $foundPoints,
        ]);
    }
}
