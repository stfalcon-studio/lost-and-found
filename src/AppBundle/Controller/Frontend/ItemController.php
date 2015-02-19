<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Item;
use AppBundle\Event\AppEvents;
use AppBundle\Entity\ItemRequest;
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
     * @Route("/lost-items", name="lost_items_list", options={"expose"=true})
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
     * @Route("/found-items", name="found_items_list", options={"expose"=true})
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
            'form' => $form->createView(),
            'pageType' => 'lost',
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
            'form' => $form->createView(),
            'pageType' => 'found',
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

        $vichUploader = $this->get('vich_uploader.storage.file_system');
        foreach ($item->getPhotos() as $photo) {
            if ($photo->getImageName() !== null) {
                $photo->setImageName(
                    $this
                        ->get('service_container')
                        ->getParameter('host') . $vichUploader
                        ->resolveUri($photo, 'imageFile')
                );
            } else {
                $photo->setImageName(null);
            }
        }

        if (!$item) {
            throw $this->createNotFoundException('Item not found.');
        }

        $request = $this->getDoctrine()
            ->getRepository('AppBundle:ItemRequest')
            ->findOneBy([
                'item' => $item,
                'user' => $this->getUser(),
            ]);
        $userItemRequest = false;
        if (!empty($request)) {
            $userItemRequest = true;
            $userFacebookId  = $item->getCreatedBy()->getFacebookId();

            return $this->render('frontend/item/show_item_details.html.twig', [
                'item'     => $item,
                'request'  => $userItemRequest,
                'facebook' => $userFacebookId,
            ]);
        }

        return $this->render('frontend/item/show_item_details.html.twig', [
            'item'     => $item,
            'request'  => $userItemRequest,
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
     * @Route("/show/found-points", name="show_found_points", options={"expose"=true})
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
     * @Route("/show/lost-points", name="show_lost_points", options={"expose"=true})
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

        return $this->render('/frontend/user/show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count
        ]);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Route("item/{id}/request-user", name="item_user_get_facebook", options={"expose"=true})
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function requestUserAction(Item $item)
    {
        $user = $item->getCreatedBy();

        $userItemRequest = new ItemRequest();
        $userItemRequest->setItem($item)
            ->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($userItemRequest);
        $em->flush();

        return new JsonResponse($user->getFacebookId());
    }
}
