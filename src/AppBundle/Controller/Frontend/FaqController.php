<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Event\AppEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
