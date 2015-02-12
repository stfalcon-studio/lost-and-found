<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\DBAL\Types\UserActionType;
use AppBundle\Entity\Item;
use AppBundle\Entity\UserActionLog;
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
     * Edit item
     *
     * @param Item    $item    Item
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/item/{id}/edit", name="item_edit")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function editItemAction(Item $item, Request $request)
    {
        $form = $this->createForm('item_edit', $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('session')->getFlashBag()->add('update', 'Item ' . $item->getTitle() . ' was updated!');

            return $this->redirect($this->generateUrl('user_actual_lost_items'));
        }

        if (!$item) {
            throw $this->createNotFoundException('Item not found.');
        }

        return $this->render('frontend/item/item_edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item
        ]);
    }

    /**
     * Show actual lost items
     *
     * @return Response
     *
     * @Route("/actual-lost-items", name="user_actual_lost_items")
     */
    public function showActualLostItemsAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::ACTUAL, ItemTypeType::LOST, true, false, true);


        return $this->render('frontend/user/show_actual_lost_items.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Show actual found items
     *
     * @return Response
     *
     * @Route("/actual-found-items", name="user_actual_found_items")
     */
    public function showActualFoundItemsAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::ACTUAL, ItemTypeType::FOUND, true, false, true);

        return $this->render('frontend/user/show_actual_found_items.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Show resolved lost items
     *
     * @return Response
     *
     * @Route("/resolved-lost-items", name="user_resolved_lost_items")
     */
    public function showResolvedLostItemsAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::RESOLVED, ItemTypeType::LOST, true, false, true);

        return $this->render('frontend/user/show_resolved_lost_items.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Show resolved found items
     *
     * @return Response
     *
     * @Route("/resolved-found-items", name="user_resolved_found_items")
     */
    public function showResolvedFoundItemsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::RESOLVED, ItemTypeType::FOUND, true, false, true);

        return $this->render('frontend/user/show_resolved_found_items.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/deactivated-items", name="user_deactivated_items")
     */
    public function showDeactivatedItemsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        return $this->render('frontend/user/show_deactivated_items.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/not-moderated-items", name="user_not_moderated_items")
     */
    public function showNotModeratedItemsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $items = $itemRepository->getNotModeratedItems($this->getUser(), false);

        return $this->render('frontend/user/show_not_moderated_items.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/deauthorize", name="user_deauthorize")
     */
//    public function facebookDeauthorizeAction()
//    {
//        $actionLog = new UserActionLog();
//        $actionLog->setActionType(UserActionType::DEAUTHORIZE);
//        $actionLog->setUser($this->getUser());
//        $actionLog->setCreatedAt(new \DateTime('now'));
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($actionLog);
//        $em->flush();
//
//        return $this->redirect($this->generateUrl('homepage'));
//    }
}
