<?php

namespace AppBundle\Controller\API;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Faq;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

/**
 * FaqController
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Artem Genvald      <genvaldartem@gmail.com>
 */
class FaqController extends FOSRestController
{
    /**
     * @return Faq[]
     *
     * @Rest\View()
     * @Rest\Get("/api/v1/faq", name="get_faq", defaults={ "_format" = "json" })
     */
    public function getFaqListAction()
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        $faq = $faqRepository->getFaqList();

        return $faq;
    }

    /**
     * @param int $id ID
     *
     * @return Faq
     *
     * @Rest\View()
     * @Rest\Get("/api/v1/faq/{id}", name="get_faq_by_id", defaults={ "_format" = "json" })
     */
    public function getFaqAction($id)
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        $faq = $faqRepository->getFaqById($id);

        if (!$faq) {
            throw $this->createNotFoundException('Unable to find faq entity');
        }

        return $faq;
    }

    /**
     * @param Request $request
     *
     * @return array|View
     *
     * @Rest\View()
     * @Rest\Post("/api/v1/faq", name="create_faq")
     */
    public function postFaqAction(Request $request)
    {
        $form = $this->createForm('faq', new Faq());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $faq = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();

            return Codes::HTTP_CREATED;
        }

        return [
            'form' => $form,
        ];
    }

    /**
     * @param Request $request Request
     * @param int     $id      ID
     *
     * @return array|View
     *
     * @Rest\View()
     * @Rest\Put("/api/v1/faq/{id}", name = "put_faq")
     */
    public function putFaqAction(Request $request, $id)
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        /** @var Faq $faq */
        $faq = $faqRepository->findOneBy([
            'id' => $id,
        ]);

        $form = $this->createForm('faq', $faq);
        $form->handleRequest($request);

        if (!$faq) {
            throw $this->createNotFoundException('Unable to find faq entity');
        }

        if ($form->isValid()) {
            $question = $form->getData('question');
            $answer = $form->getData('answer');
            $enabled = $form->getData('enabled');

            $faq
                ->setAnswer($answer)
                ->setEnabled($enabled)
                ->setQuestion($question);

            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();

            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @param int $id ID
     *
     * @return View
     *
     * @Rest\Delete("/api/v1/faq/{id}", name="delete_faq_by_id")
     */
    public function deleteFaqAction($id)
    {
        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        /** @var Faq $faq */
        $faq = $faqRepository->findOneBy([
            'id' => $id,
        ]);

        if (!$faq) {
            throw $this->createNotFoundException('Unable to find faq entity');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($faq);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}
