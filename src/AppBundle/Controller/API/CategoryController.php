<?php

namespace AppBundle\Controller\API;

use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 * CategoryController
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class CategoryController extends FOSRestController
{
    /**
     * @return Category[]
     *
     * @Route("/api/v1/categories", name="api_get_categories", defaults={ "_format" = "json" })
     */
    public function getCategoriesAction()
    {
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getCategories();

        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($categories, 'json');

        return new Response($reports);
//        return $categories;
    }
}
