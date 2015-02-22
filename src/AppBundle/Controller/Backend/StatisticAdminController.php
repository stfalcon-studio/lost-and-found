<?php

namespace AppBundle\Controller\Backend;

use AppBundle\DBAL\Types\ItemTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * StatisticAdminController
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class StatisticAdminController extends Controller
{
    /**
     * Show Statistic
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/admin/statistic", name="admin_show_statistic")
     */
    public function showStatisticAction(Request $request)
    {
        $itemRepository     = $this->getDoctrine()->getRepository('AppBundle:Item');
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $foundItems = $itemRepository->getItemsOrderByCategory(ItemTypeType::FOUND);
        $lostItems  = $itemRepository->getItemsOrderByCategory(ItemTypeType::LOST);
        $categories = $categoryRepository->getCategories();

        $form = $this->createForm('statistic');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $from = $form->get('from')->getData();
            $to   = $form->get('to')->getData();

            $foundItems = $itemRepository->getItemsOrderByCategory(ItemTypeType::FOUND, $from, $to);
            $lostItems  = $itemRepository->getItemsOrderByCategory(ItemTypeType::LOST, $from, $to);
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
