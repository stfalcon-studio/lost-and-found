<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\Item;
use AppBundle\Event\AppEvents;
use AppBundle\Entity\UserItemRequest;
use AppBundle\Event\NewItemAddedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
        /** @var \AppBundle\Repository\CategoryRepository $categoryRepository */
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getCategories();

        return $this->render('frontend/item/lost_items.html.twig', [
            'categories' => $categories,
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
        /** @var \AppBundle\Repository\CategoryRepository $categoryRepository */
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getCategories();

        return $this->render('frontend/item/found_items.html.twig', [
            'categories'  => $categories,
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

            $this->get('event_dispatcher')->dispatch(AppEvents::NEW_ITEM_ADDED, new NewItemAddedEvent($item));

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontend/item/add_lost_item.html.twig', [
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

            $this->get('event_dispatcher')->dispatch(AppEvents::NEW_ITEM_ADDED, new NewItemAddedEvent($item));

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('frontend/item/add_found_item.html.twig', [
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

        return $this->render('frontend/item/show_item_details.html.twig', [
            'item' => $item,
        ]);
    }

    /**
     * Get found points
     *
     * @param Request $request Request
     *
     * @throws AccessDeniedException
     *
     * @return Response
     *
     * @Route("/show/found-points", name="show_found_points")
     */
    public function getFoundPointsAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $foundMarkers = $itemRepository->getFoundMarkers();

        $router = $this->get('router');

        foreach ($foundMarkers as &$item) {
            $item['link'] = $router->generate(
                'item_details',
                [
                    'id' => $item['itemId']
                ],
                $router::ABSOLUTE_URL
            );
        }

        return new JsonResponse($foundMarkers);
    }

    /**
     * Get lost points
     *
     * @param Request $request Request
     *
     * @return Response
     * @throws AccessDeniedException
     *
     * @Route("/show/lost-points", name="show_lost_points")
     */
    public function getLostPointsAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $lostMarkers = $itemRepository->getLostMarkers();

        $router = $this->get('router');

        foreach ($lostMarkers as &$item) {
            $item['link'] = $router->generate(
                'item_details',
                [
                    'id' => $item['itemId']
                ],
                $router::ABSOLUTE_URL
            );
        }

        return new JsonResponse($lostMarkers);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Route("item/{id}/deactivate", name="item_deactivate")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemDeactivatedAction(Item $item)
    {
        $item->setActive(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $items          = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        $this->get('session')->getFlashBag()->add('notice', 'Item ' . $item->getTitle() . ' was deactivated!');

        return $this->render(':frontend/user:show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Route("item/{id}/delete", name="item_delete")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemDeleteAction(Item $item)
    {
        $item->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $items          = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        $this->get('session')->getFlashBag()->add('notice', 'Item ' . $item->getTitle() . ' was deleted!');

        return $this->render(':frontend/user:show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Route("item/{id}/activate", name="item_activate")
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemActivatedAction(Item $item)
    {
        $item->setActive(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $items          = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        $this->get('session')->getFlashBag()->add('notice', 'Item ' . $item->getTitle() . ' was activated!');

        return $this->render(':frontend/user:show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @Route("item/{id}/getUserFacebook", name="item_user_get_facebook")
     */
    public function getUserFacebook($id)
    {
        $item = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->find($id);

        $user = $item->getCreatedBy();

        $userItemRequest = new UserItemRequest();
        $userItemRequest->setItem($item)
            ->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($userItemRequest);
        $em->flush();

        return new JsonResponse($user->getFacebookId());
    }
}
