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
 * Class FAQ Controller
 *
 */
class FAQController extends Controller
{
    /**
     * Show FAQ
     *
     * @return Response
     *
     * @Route("/FAQ", name="show_FAQ")
     */
    public function allFAQListAction()
    {
        $FAQRepository = $this->getDoctrine()->getRepository('AppBundle:FAQ');

        $FAQ = $FAQRepository->getAllFAQ();


        return $this->render('frontend/default/FAQ.html.twig', [
            'FAQ' => $FAQ,
        ]);
    }
}
