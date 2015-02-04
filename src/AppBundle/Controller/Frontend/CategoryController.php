<?php
/**
 * Created by PhpStorm.
 * User: svatok
 * Date: 04.02.15
 * Time: 15:40
 */

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CategoryController
 *
 * @author svatok13
 */
class CategoryController extends Controller
{
    /**
     * Get found points
     *
     * @return Response
     *
     * @Route("/get/categories", name="get_categories")
     */
    public function getAllModeratedAction()
    {
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getAllModerated();

        $response = new Response(json_encode($categories));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}