<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Frontend DefaultController
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Yuri Svatok    <svatok13@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @return Response
     *
     * @Method("GET")
     * @Route("/", name="homepage")
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
     * @return Response
     *
     * @Method("GET")
     * @Route("/feedback", name="feedback")
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

        return $this->render('frontend/default/feedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
