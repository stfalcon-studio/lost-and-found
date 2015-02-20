<?php

namespace AppBundle\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * StatisticAdminController
 *
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 */
class StatisticAdminController extends Controller
{
    /**
     * Show Statistic
     *
     * @param Request $request
     *
     * @return array
     *
     * @Route("/admin/statistic", name="admin_show_statistic")
     */
    public function showStatisticAction(Request $request)
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $foundItems = $itemRepository->getFoundItemsOrderByCategory();
        $lostItems = $itemRepository->getLostItemsOrderByCategory();
        $categories = $categoryRepository->getAllEnabled();

        $form = $this->createForm('statistic');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $from = $form->get('from')->getData();
            $to = $form->get('to')->getData();

            $foundItems = $itemRepository->getFoundItemsOrderByCategory($from, $to);
            $lostItems = $itemRepository->getLostItemsOrderByCategory($from, $to);
        }

        return $this->render(':backend:statistic.html.twig', [
            'form'        => $form->createView(),
            'found_items' => $foundItems,
            'lost_items'  => $lostItems,
            'categories'  => $categories,
            'admin_pool'  => $this->container->get('sonata.admin.pool'),
        ]);
    }
}
