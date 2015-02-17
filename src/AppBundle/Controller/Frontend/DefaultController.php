<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Event\AppEvents;
use AppBundle\Event\FeedbackSendEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Request;

/**
 * DefaultController
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author svatok13 <svatok13@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Homepage
     *
     * @Route("/", name="homepage")
     *
     * @return array
     */
    public function indexAction()
    {
        /** @var \AppBundle\Repository\ItemRepository $itemRepository */
        $itemRepository = $this->getDoctrine()->getRepository('AppBundle:Item');

        $foundItems = $itemRepository->getActiveFoundItem();
        $lostItems  = $itemRepository->getActiveLostItem();

        return $this->render('frontend/default/index.html.twig', [
            'found_items'  => $foundItems,
            'lost_items'   => $lostItems
        ]);
    }

    /**
     * Feedback
     *
     * @Route("/feedback", name="feedback")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function feedbackAction(Request $request)
    {
        $form = $this->createForm('feedback');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $email = $form->get('email')->getData();
            $message = $form->get('message')->getData();

            $adminEmails = $this->container->getParameter('admin_emails');
            $mailer = $this->get('mailer');

            $feedback = $mailer
                ->createMessage()
                ->setSubject('New feedback!')
                ->setFrom($email)
                ->setTo($adminEmails)
                ->setBody($message);

            $mailer->send($feedback);

            $this->get('session')->getFlashBag()->add('notice', 'Your feedback was sent!');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(':frontend/default:feedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
