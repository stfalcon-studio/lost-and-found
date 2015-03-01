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

use AppBundle\DBAL\Types\ItemTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Backend StatisticAdminController
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class StatisticAdminController extends Controller
{
    /**
     * Show Statistic
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
     * @Route("/admin/statistic", name="admin_show_statistic")
     */
    public function showStatisticAction(Request $request)
    {
        $itemRepository     = $this->getDoctrine()->getRepository('AppBundle:Item');
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $foundItems = $itemRepository->getItemsOrderByCategory(ItemTypeType::FOUND);
        $lostItems  = $itemRepository->getItemsOrderByCategory(ItemTypeType::LOST);
        $categories = $categoryRepository->getParentCategories();

        $form = $this->createForm('statistic');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $from = $form->get('from')->getData();
            $to   = $form->get('to')->getData();

            $foundItems = $itemRepository->getItemsOrderByCategory(ItemTypeType::FOUND, $from, $to);
            $lostItems  = $itemRepository->getItemsOrderByCategory(ItemTypeType::LOST, $from, $to);
        }

        return $this->render(':backend:statistic.html.twig', [
            'admin_pool'  => $this->container->get('sonata.admin.pool'),
            'form'        => $form->createView(),
            'found_items' => $foundItems,
            'lost_items'  => $lostItems,
            'categories'  => $categories,
        ]);
    }
}
