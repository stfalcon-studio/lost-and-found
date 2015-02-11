<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * CategoryController
 *
 * @author svatok13
 */
class CategoryController extends Controller
{
    /**
     * Get all moderated categories
     *
     * @param Request $request
     *
     * @return Response
     * @throws AccessDeniedException
     *
     * @Route("/get/categories", name="get_categories")
     */
    public function getAllModeratedAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getAllEnabled();

        $result = [];
        $vichUploader = $this->get('vich_uploader.storage.file_system');

        foreach ($categories as $category) {
            $id                   = $category->getId();
            $result[$id]['id']    = $category->getId();
            $result[$id]['title'] = $category->getTitle();
            if ($category->getImageName() !== null) {
                $result[$id]['imageName'] = $this->get('service_container')->getParameter('host')
                                            . $vichUploader->resolveUri($category, 'imageFile');
            } else {
                $result[$id]['imageName'] = null;
            }
        }

        return new Response(json_encode($result), 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
