<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Gedmo\Translatable\Entity\Repository;

/**
 * Class Faq Controller
 *
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 */
class FaqController extends Controller
{
    /**
     * Show Faq
     *
     * @param Request $request
     *
     * @Route("/faq", name="show_faq")
     *
     * @return Response
     */
    public function allFaqListAction(Request $request)
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');
        $faq = $faqRepository->findBy([
            'enabled' => true,
        ]);

        return $this->render('frontend/default/faq.html.twig', [
            'faq' => $faq,
        ]);
    }
}
