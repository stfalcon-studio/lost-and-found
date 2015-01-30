<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ItemController
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class ItemController extends Controller
{
    /**
     * @Route("/create-lost-item", name="create_lost_item")
     *
     * @param Request $request
     * @return Response
     */
    public function createLostItemAction(Request $request)
    {
        $item = new Item();

        $form = $this->createForm('lost', $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontend/default/create_lost_item.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create-found-item", name="create_found_item")
     *
     * @param Request $request
     * @return Response
     */
    public function createFoundItemAction(Request $request)
    {
        $item = new Item();

        $form = $this->createForm('found', $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontend/default/create_found_item.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}