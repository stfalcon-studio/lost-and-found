<?php
/**
 * Created by PhpStorm.
 * User: svatok
 * Date: 05.02.15
 * Time: 16:19
 */

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\User;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
            'ActualLostItems' => $items,
        ]);
    }

    /**
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
            'ActualFoundItems' => $items,
        ]);
    }

    /**
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
            'ResolvedLostItems' => $items,
        ]);
    }

    /**
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
            'ResolvedFoundItems' => $items,
        ]);
    }

    /**
     * Item edit
     *
     * @param integer $id
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/item/{id}/edit", name="item_edit")
     */
    public function itemEditAction($id, Request $request)
    {
        $item = $this->getDoctrine()
                     ->getRepository('AppBundle:Item')
                     ->findOneBy([
                         'id' => $id,
                     ]);
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
            'form' => $form->createView(),
        ]);
    }
}