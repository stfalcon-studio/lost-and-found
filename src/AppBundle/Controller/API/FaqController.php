<?php

namespace AppBundle\Controller\API;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Faq;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * FaqController
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class FaqController extends FOSRestController
{

    /**
     * @return Faq[]
     *
     * @Rest\View()
     * @Route("/api/v1/faq", name="api_get_faq", defaults={ "_format" = "json" })
     */
    public function getFaqListAction()
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        $faq = $faqRepository->getFaqList();

//        $serializer = $this->container->get('serializer');
//        $reports = $serializer->serialize($faq, 'json');

        return $faq;
    }
}
