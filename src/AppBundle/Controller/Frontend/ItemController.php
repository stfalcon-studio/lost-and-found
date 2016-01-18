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

use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\Category;
use AppBundle\Entity\Item;
use AppBundle\Entity\ItemRequest;
use AppBundle\Entity\Message;
use AppBundle\Event\AppEvents;
use AppBundle\Event\NewItemAddedEvent;
use AppBundle\Form\Type\ItemsListType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Frontend ItemController
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
 */
class ItemController extends Controller
{
    // region Lost Items

    /**
     * Lost items list
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
     * @Route("/lost-items", name="lost_items_list")
     */
    public function lostItemsListAction(Request $request)
    {
        $categories = $this->listAction();

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $lostItems      = $itemRepository->getItemsByDate(ItemTypeType::LOST);

        $form = $this->createForm('items_list_type');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data               = $form->getData();
            $selectedCategories = $form->get('categories')->getData();

            $categoriesArr = [];

            foreach ($selectedCategories as $categoryNumber) {
                array_push($categoriesArr, $categories[$categoryNumber]->getId());
            }

            $lostItems = $itemRepository->getItemsByDate(
                ItemTypeType::LOST,
                $data['from'],
                $data['to'],
                $categoriesArr
            );
        }

        $router       = $this->get('router');
        $vichUploader = $this->get('vich_uploader.storage.file_system');
        $host         = $this->get('service_container')->getParameter('host');

        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        foreach ($lostItems as &$item) {
            $item['link'] = $router->generate(
                'item_details',
                [
                    'id' => $item['id'],
                ],
                $router::ABSOLUTE_URL
            );

            if (null !== $item['categoryImage']) {
                foreach ($categories as $category) {
                    if ($category->getId() == $item['categoryId']) {
                        $item['categoryImage'] = $host.$vichUploader->resolveUri($category, 'imageFile');
                        $item['categoryTitle'] = $category->getTitle();
                    }
                }
            } else {
                $item['categoryImage'] = null;
            }
        }
        unset($item); // Remove link

        return $this->render('frontend/item/lost_items.html.twig', [
            'form'       => $form->createView(),
            'lost_items' => $lostItems,
        ]);
    }

    /**
     * Add lost item
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
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
            'form'     => $form->createView(),
            'pageType' => 'lost',
        ]);
    }

    /**
     * Get lost points
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @throws AccessDeniedException
     *
     * @Method("GET")
     * @Route("/show/lost-points", name="show_lost_points", options={"expose"=true})
     */
    public function getLostPointsAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $lostMarkers = $itemRepository->getMarkers(ItemTypeType::LOST);

        $router = $this->get('router');

        foreach ($lostMarkers as &$item) {
            $item['link'] = $router->generate(
                'item_details',
                [
                    'id' => $item['itemId'],
                ],
                $router::ABSOLUTE_URL
            );
        }

        return new JsonResponse($lostMarkers);
    }

    // endregion Lost items

    // region Found Items

    /**
     * Found items list
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
     * @Route("/found-items", name="found_items_list", options={"expose"=true})
     */
    public function foundItemsListAction(Request $request)
    {
        /** @var Category $categories */
        $categories = $this->listAction();

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $foundItems     = $itemRepository->getItemsByDate(ItemTypeType::FOUND);

        $form = $this->createForm(new ItemsListType($categories));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data               = $form->getData();
            $selectedCategories = $form->get('categories')->getData();

            $categoriesArr = [];

            foreach ($selectedCategories as $categoryNumber) {
                array_push($categoriesArr, $categories[$categoryNumber]->getId());
            }

            $foundItems = $itemRepository->getItemsByDate(
                ItemTypeType::FOUND,
                $data['from'],
                $data['to'],
                $categoriesArr
            );
        }

        $router       = $this->get('router');
        $vichUploader = $this->get('vich_uploader.storage.file_system');
        $host         = $this->get('service_container')->getParameter('host');

        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        foreach ($foundItems as &$item) {
            $item['link'] = $router->generate(
                'item_details',
                [
                    'id' => $item['id'],
                ],
                $router::ABSOLUTE_URL
            );
            if (null !== $item['categoryImage']) {
                foreach ($categories as $category) {
                    if ($category->getId() == $item['categoryId']) {
                        $item['categoryImage'] = $host.$vichUploader->resolveUri($category, 'imageFile');
                        $item['categoryTitle'] = $category->getTitle();
                    }
                }
            } else {
                $item['categoryImage'] = null;
            }
        }
        unset($item); // Remove link

        return $this->render('frontend/item/found_items.html.twig', [
            'form'        => $form->createView(),
            'found_items' => $foundItems,
        ]);
    }

    /**
     * Add found item
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
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
            'form'     => $form->createView(),
            'pageType' => 'found',
        ]);
    }

    /**
     * Get found points
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @throws AccessDeniedException
     *
     * @Method("GET")
     * @Route("/show/found-points", name="show_found_points", options={"expose"=true})
     */
    public function getFoundPointsAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $foundMarkers = $itemRepository->getMarkers(ItemTypeType::FOUND);

        $router = $this->get('router');

        foreach ($foundMarkers as &$item) {
            $item['link'] = $router->generate(
                'item_details',
                [
                    'id' => $item['itemId'],
                ],
                $router::ABSOLUTE_URL
            );
        }

        return new JsonResponse($foundMarkers);
    }

    // endregion Found items

    // region Additional Items Functions

    /**
     * Item details
     *
     * @param int     $id      ID
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method({"GET", "POST"})
     * @Route("/item/{id}/details", name="item_details")
     */
    public function itemDetailsAction($id, Request $request)
    {
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $item           = $itemRepository->findModeratedItemById($id);

        if (!($item instanceof Item)) {
            throw $this->createNotFoundException();
        }

        $vichUploader = $this->get('vich_uploader.storage.file_system');

        $host = $this->get('service_container')->getParameter('host');

        foreach ($item->getPhotos() as $photo) {
            if (null !== $photo->getImageName()) {
                $photo->setImageName($host.$vichUploader->resolveUri($photo, 'imageFile'));
            } else {
                $photo->setImageName(null);
            }
        }

        if (!$item) {
            throw $this->createNotFoundException('Item not found.');
        }

        $form = $this->createForm('item_details');
        $form->handleRequest($request);

        $messageForm = $this->createForm('send_message');
        $messageForm->handleRequest($request);

        if ($messageForm->isValid()) {
            $messageData = $messageForm->getData();
            $receiver    = $item->getCreatedBy();

            $message = (new Message())
                ->setReceiver($receiver)
                ->setSender($this->getUser())
                ->setContent($messageData['content']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Your message was sent!');
            unset($messageForm);
            $messageForm = $this->createForm('send_message');
        }

        if (null !== $this->getUser()) {
            $requestRepository = $this->getDoctrine()->getRepository('AppBundle:ItemRequest');
            $request           = $requestRepository->findUserItemRequest($item, $this->getUser());

            $userItemRequest = false;

            if (!empty($request)) {
                $userItemRequest = true;
                $userFacebookId  = $item->getCreatedBy()->getFacebookId();

                return $this->render('frontend/item/show_item_details.html.twig', [
                    'item'         => $item,
                    'request'      => $userItemRequest,
                    'facebook'     => $userFacebookId,
                    'form'         => $form->createView(),
                    'message_form' => $messageForm->createView(),
                ]);
            }
        } else {
            $userItemRequest = false;
        }

        return $this->render('frontend/item/show_item_details.html.twig', [
            'item'         => $item,
            'request'      => $userItemRequest,
            'form'         => $form->createView(),
            'message_form' => $messageForm->createView(),
        ]);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("item/{id}/deactivate", name="item_deactivate", options={"i18n"=false})))
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemDeactivatedAction(Item $item)
    {
        if ($item->getCreatedBy()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $item->setActive(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $items          = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        $this->get('session')->getFlashBag()->add('notice', 'Item '.$item->getTitle().' was deactivated!');

        return $this->render('frontend/user/show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("item/{id}/delete", name="item_delete", options={"i18n"=false})))
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemDeleteAction(Item $item)
    {
        if ($item->getCreatedBy()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $item->setDeleted(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $items          = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        $this->get('session')->getFlashBag()->add('notice', 'Item '.$item->getTitle().' was deleted!');

        return $this->render('frontend/user/show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * @param Item $item Item
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("item/{id}/activate", name="item_activate", options={"i18n"=false})))
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function itemActivatedAction(Item $item)
    {
        if ($item->getCreatedBy()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        $item->setActive(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        $count = $this->get('app.user_items_count');

        $count = $count->getCount($this->getUser());

        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');
        $items          = $itemRepository->getDeactivatedItems($this->getUser(), false, false);

        $this->get('session')->getFlashBag()->add('notice', 'Item '.$item->getTitle().' was activated!');

        return $this->render('/frontend/user/show_deactivated_items.html.twig', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    // endregion Additional Items Functions

    /**
     * Request user facebook page
     *
     * @param Item    $item    Item
     * @param Request $request Request
     *
     * @return Response
     *
     * @Method("POST")
     * @Route("item/{id}/request-user", name="item_user_get_facebook", options={"expose"=true, "i18n"=false}))
     * @ParamConverter("item", class="AppBundle\Entity\Item")
     */
    public function requestUserAction(Item $item, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm('item_details');

        if ($request->isMethod('post')) {
            $form->submit($request);

            if ($form->isValid()) {
                $user = $item->getCreatedBy();

                $userItemRequest = (new ItemRequest())
                    ->setItem($item)
                    ->setUser($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($userItemRequest);
                $em->flush();

                return new JsonResponse($user->getFacebookId());
            }
        }

        throw new BadRequestHttpException();
    }

    /**
     * List action
     *
     * @return Category[]
     */
    private function listAction()
    {
        /** @var \AppBundle\Repository\CategoryRepository $categoryRepository */
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $categories         = $categoryRepository->getParentCategories();

        return $categories;
    }
}
