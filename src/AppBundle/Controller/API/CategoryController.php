<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\API;

use AppBundle\Entity\Category;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * API CategoryController
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 * @author Artem Genvald  <genvaldartem@gmail.com>
 *
 * @Route("v1/")
 */
class CategoryController extends FOSRestController
{
    /**
     * @return Category[]
     *
     * @Route("categories", name="api_get_categories", defaults={"_format"="json"})
     */
    public function getCategoriesAction()
    {
        $categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $categories = $categoryRepository->getCategories();

        $serializer = $this->container->get('serializer');
        $reports = $serializer->serialize($categories, 'json');

        return new Response($reports);
    }
}
