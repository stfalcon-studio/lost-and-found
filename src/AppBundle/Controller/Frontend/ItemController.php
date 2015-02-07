<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ItemController
 *
 * @author Logans <Logansoleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemController extends Controller
{
    /**
     * Lost items list
     *
     * @return Response
     *
     * @Route("/lost-items", name="lost_items_list")
     */
    public function lostItemsListAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $lostItems  = $itemRepository->getActiveLostItem();

        return $this->render('frontend/item/lost_items.html.twig', [
            'lost_items' => $lostItems
        ]);
    }

    /**
     * Found items list
     *
     * @return Response
     *
     * @Route("/found-items", name="found_items_list")
     */
    public function foundItemsListAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getActiveFoundItem();

        return $this->render('frontend/item/found_items.html.twig', [
            'found_items' => $foundItems
        ]);
    }

    /**
     * Add lost item
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/add-lost-item", name="add_lost_item")
     */
    public function addLostItemAction(Request $request)
    {
        $form = $this->createForm('lost_item', new Item());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Your item was added!');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontend/default/add_lost_item.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Add found item
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/add-found-item", name="add_found_item")
     */
    public function addFoundItemAction(Request $request)
    {
        $form = $this->createForm('found_item', new Item());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Your item was added!');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontend/default/add_found_item.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Item details
     *
     * @param int $id ID
     *
     * @return Response
     *
     * @Route("/item/{id}/details", name="item_details")
     */
    public function itemDetailsAction($id)
    {
        $item = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->findOneBy([
                'id'        => $id,
                'moderated' => true,
            ]);

        if (!$item) {
            throw $this->createNotFoundException('Item not found.');
        }

        return $this->render('frontend/default/item_details.html.twig', [
            'item' => $item
        ]);
    }

    /**
     * Get found points
     *
     * @return Response
     *
     * @Route("/show/found-points", name="show_found_points")
     */
    public function getFoundPointsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $foundPoints = $itemRepository->getFoundPoints();

        return new Response(json_encode($foundPoints), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Get lost points
     *
     * @return Response
     *
     * @Route("/show/lost-points", name="show_lost_points")
     */
    public function getLostPointsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $lostPoints = $itemRepository->getLostPoints();

        return new Response(json_encode($lostPoints), 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
