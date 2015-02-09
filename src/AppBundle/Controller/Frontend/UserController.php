<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\User;
use AppBundle\Entity\Item;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 *
 * @Route("/profile", name="user_profile")
 */
class UserController extends Controller
{
    /**
     * Show lost actual items
     *
     * @return Response
     *
     * @Route("/lost-actual", name="user_lost_actual")
     */
    public function showLostActualAction()
    {
        $user = $this->getUser();

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($user, ItemStatusType::ACTUAL, ItemTypeType::LOST);

        return $this->render(':frontend/profile:user_profile_lost_actual.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Show found actual items
     *
     * @return Response
     *
     * @Route("/found-actual", name="user_found_actual")
     */
    public function showFoundActualAction()
    {
        $user = $this->getUser();

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($user, ItemStatusType::ACTUAL, ItemTypeType::FOUND);

        return $this->render(':frontend/profile:user_profile_found_actual.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Show lost resolved items
     *
     * @return Response
     *
     * @Route("/lost-resolved", name="user_lost_resolved")
     */
    public function showLostResolvedAction()
    {
        $user = $this->getUser();

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($user, ItemStatusType::RESOLVED, ItemTypeType::LOST);

        return $this->render(':frontend/profile:user_profile_lost_resolved.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Show found resolved items
     *
     * @return Response
     *
     * @Route("/found-resolved", name="user_found_resolved")
     */
    public function showFoundResolvedAction()
    {
        $user = $this->getUser();

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($user, ItemStatusType::RESOLVED, ItemTypeType::FOUND);

        return $this->render(':frontend/profile:user_profile_found_resolved.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Item edit
     *
     * @param Item    $item    Item
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/item/{id}/edit", name="item_edit")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemEditAction(Item $item, Request $request)
    {
        $form = $this->createForm('item_edit', $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('session')->getFlashBag()->add('update', 'Your item was updated!');

            return $this->redirect($this->generateUrl('user_found_actual'));
        }

        if (!$item) {
            throw $this->createNotFoundException('Item not found.');
        }

        return $this->render(':frontend/default:item_edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }
}
