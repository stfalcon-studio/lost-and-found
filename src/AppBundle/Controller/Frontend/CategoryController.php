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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Frontend CategoryController
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
     * @Method("GET")
     * @Route("/get/categories", name="get_categories", options={"expose"=true})
     */
    public function getAllModeratedAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }

        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $parentCategories = $categoryRepository->getParentCategories();

        $vichUploader = $this->get('vich_uploader.storage.file_system');
        $result = [];

        $host = $this->get('service_container')->getParameter('host');

        foreach ($parentCategories as $category) {
            $categoryId = $category->getId();

            $result[$categoryId]['id']    = $categoryId;
            $result[$categoryId]['title'] = $category->getTitle();
            $result[$categoryId]['imageName'] = null;

            // Get all children as array for current category
            $result[$categoryId]['children'] = $categoryRepository->getChildrenQuery($category)->getArrayResult();

            if (null !== $category->getImageName()) {
                $result[$categoryId]['imageName'] = $host.$vichUploader->resolveUri($category, 'imageFile');
            }
        }

        return new JsonResponse($result);
    }
}
