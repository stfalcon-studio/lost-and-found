<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Faq Controller
 *
 */
class FaqController extends Controller
{
    /**
     * Show Faq
     *
     * @return Response
     *
     * @Route("/faq", name="show_faq")
     */
    public function allFaqListAction()
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        $faq = $faqRepository->getAllFaq();

        return $this->render('frontend/default/faq.html.twig', [
            'faq' => $faq,
        ]);
    }
}
