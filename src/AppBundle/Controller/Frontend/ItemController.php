<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\DBAL\Types\ItemTypeType;

/**
 * ItemController
 *
 * @author Logans <Logansoleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class ItemController extends Controller
{
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
            'form' => $form->createView(),
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
            'form' => $form->createView(),
        ]);
    }

    /**
     * Item details
     *
     * @param integer $id
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
                'id' => $id,
                'moderated' => true,
            ]);

        $foundPoint = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->getFoundPoint($id);

        if (!$item) {
            throw $this->createNotFoundException('Item not found');
        }

        return $this->render('frontend/default/item_details.html.twig', [
            'item' => $item,
            'found_point' => $foundPoint,
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

        $response = new Response(json_encode($foundPoints));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
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

        $response = new Response(json_encode($lostPoints));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
