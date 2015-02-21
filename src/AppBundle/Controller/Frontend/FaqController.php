<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Gedmo\Translatable\Entity\Repository;

/**
 * Class Faq Controller
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class FaqController extends Controller
{
    /**
     * Show all enabled F.A.Q.
     *
     * @Route("/faq", name="show_faq")
     *
     * @return Response
     */
    public function allFaqListAction()
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        $faq = $faqRepository->getAllEnabled();

        return $this->render('frontend/default/faq.html.twig', [
            'faq' => $faq
        ]);
    }
}
