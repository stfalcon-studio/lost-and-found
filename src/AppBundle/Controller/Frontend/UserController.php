<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Frontend;

use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Frontend UserController
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 *
 * @Route("/profile", name="user_profile")
 */
class UserController extends Controller
{
    // region Lost Items

    /**
     * Show actual lost items
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/lost-items/actual", name="user_actual_lost_items")
     */
    public function showActualLostItemsAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::ACTUAL, ItemTypeType::LOST, true, false, true);

        return $this->render('frontend/user/show_actual_lost_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * Show resolved lost items
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/lost-items/resolved", name="user_resolved_lost_items")
     */
    public function showResolvedLostItemsAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::RESOLVED, ItemTypeType::LOST, true, false, true);

        return $this->render('frontend/user/show_resolved_lost_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    // endregion Lost Items

    // region Found Items

    /**
     * Show actual found items
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/found-items/actual", name="user_actual_found_items")
     */
    public function showActualFoundItemsAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::ACTUAL, ItemTypeType::FOUND, true, false, true);

        return $this->render('frontend/user/show_actual_found_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * Show resolved found items
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/found-items/resolved", name="user_resolved_found_items")
     */
    public function showResolvedFoundItemsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $items = $itemRepository->getUserItems($this->getUser(), ItemStatusType::RESOLVED, ItemTypeType::FOUND, true, false, true);

        return $this->render('frontend/user/show_resolved_found_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    // endregion Found Items

    // region Addtional Items Functions

    /**
     * Edit item
     *
     * @param Item    $item    Item
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
     * @Route("/item/{id}/edit", name="item_edit")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function editItemAction(Item $item, Request $request)
    {
        // Check if item belongs to user
        if ($item->getCreatedBy()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm('item_edit', $item);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('session')->getFlashBag()->add('update', 'Item '.$item->getTitle().' was updated!');

            return $this->redirect($this->generateUrl('user_actual_lost_items'));
        }

        if (!$item) {
            throw $this->createNotFoundException('Item not found.');
        }

        return $this->render('frontend/item/item_edit.html.twig', [
            'form' => $form->createView(),
            'item' => $item,
        ]);
    }

    /**
     * Show deactivated items
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/deactivated-items", name="user_deactivated_items")
     */
    public function showDeactivatedItemsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $items = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        return $this->render('frontend/user/show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * Show not moderated items
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/not-moderated-items", name="user_not_moderated_items")
     */
    public function showNotModeratedItemsAction()
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $items = $itemRepository->getNotModeratedItems($this->getUser(), false);

        return $this->render('frontend/user/show_not_moderated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * Show item requests
     *
     * @param Item $item Item
     *
     * @return Response
     *
     * @Route("/item/{id}/requests", name="user_item_requests")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function showItemRequestsAction(Item $item)
    {
        if ($item->getCreatedBy()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $requests = $itemRepository->getItemRequests($item);

        return $this->render('frontend/user/show_item_requests.html.twig', [
            'requests' => $requests,
            'title'    => $item->getTitle(),
        ]);
    }

    // endregion Addtional Items Functions

//    /**
//     * @return Response
//     *
//     * @Route("/deauthorize", name="user_deauthorize")
//     */
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

    // region Messages

    /**
     * Show send messages
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/messages/sent", name="user_sent_messages")
     */
    public function showSendMessagesAction()
    {
        /** @var \AppBundle\Repository\MessageRepository $messageRepository */
        $messageRepository = $this->getDoctrine()->getRepository('AppBundle:Message');

        $count = $this->get('app.user_items_count');
        $count = $count->getCount($this->getUser());

        $messages = $messageRepository->getSendMessages($this->getUser());

        return $this->render('frontend/user/show_messages.html.twig', [
            'messages' => $messages,
            'count'    => $count,
            'type'     => 'sent',
        ]);
    }

    /**
     * Show received messages
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/messages/received", name="user_received_messages")
     */
    public function showReceivedMessagesAction()
    {
        /** @var \AppBundle\Repository\MessageRepository $messageRepository */
        $messageRepository = $this->getDoctrine()->getRepository('AppBundle:Message');

        $count = $this->get('app.user_items_count');
        $count = $count->getCount($this->getUser());

        $messages = $messageRepository->getReceivedMessages($this->getUser());

        return $this->render('frontend/user/show_messages.html.twig', [
            'messages' => $messages,
            'count'    => $count,
            'type'     => 'receive',
        ]);
    }

    // endregion Messages
}
