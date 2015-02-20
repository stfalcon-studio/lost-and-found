<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DefaultController
 *
 * @author Artem Genvald  <GenvaldArtem@gmail.com>
 * @author Yuri Svatok    <Svatok13@gmail.com>
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('frontend/default/index.html.twig');
    }

    /**
     * Feedback
     *
     * @param Request $request
     *
     * @Route("/feedback", name="feedback")
     *
     * @return Response
     */
    public function feedbackAction(Request $request)
    {
        $form = $this->createForm('feedback');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();

            $adminEmails = $this->container->getParameter('admin_emails');
            $mailer = $this->get('mailer');

            $feedback = $mailer
                ->createMessage()
                ->setSubject('New feedback!')
                ->setFrom($formData['email'])
                ->setTo($adminEmails)
                ->setBody($formData['email']);

            $mailer->send($feedback);

            $this->get('session')->getFlashBag()->add('notice', 'Your feedback was sent!');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(':frontend/default:feedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
