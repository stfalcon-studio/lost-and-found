<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * CategoryController
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * Get all moderated categories
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws AccessDeniedException
     *
     * @Route("/get/categories", name="get_categories", options={"expose"=true})
     */
    public function getAllModeratedAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getCategories();

        $vichUploader = $this->get('vich_uploader.storage.file_system');
        $result = [];

        foreach ($categories as $category) {
            $id                   = $category->getId();
            $result[$id]['id']    = $category->getId();
            $result[$id]['title'] = $category->getTitle();

            if (null !== $category->getImageName()) {
                $result[$id]['imageName'] = $this
                        ->get('service_container')
                        ->getParameter('host') . $vichUploader->resolveUri($category, 'imageFile');
            } else {
                $result[$id]['imageName'] = null;
            }
        }

        return new JsonResponse($result);
    }
}
