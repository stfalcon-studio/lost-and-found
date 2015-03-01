<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller\API;

use AppBundle\Entity\Faq;
use AppBundle\Form\Type\API\FaqType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API FaqController
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Artem Genvald      <genvaldartem@gmail.com>
 *
 * @Rest\NamePrefix("api_faq_")
 * @Rest\Prefix("/v1/faqs")
 */
class FaqController extends FOSRestController
{
    /**
     * Get all F.A.Q. items or sliced by limit and offset
     *
     * GET /api/faqs
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Rest\Get("")
     */
    public function getAllAction(Request $request)
    {
        $limit  = (int) $request->get('limit');
        $offset = (int) $request->get('offset');

        $faqRepository = $this->getDoctrine()->getRepository('AppBundle:Faq');

        if ($limit > 0) {
            $faqs = $faqRepository->findEnabledWithLimitAndOffset($limit, $offset);
        } else {
            $faqs = $faqRepository->findBy(['enabled' => true]);
        }

        if (count($faqs) > 0) {
            $numberOfFaqs = count($faqs);

            $data = [
                'faqs' => $faqs,
                '_metadata'   => [
                    'total'  => count($faqs),
                    'limit'  => $limit > 0 ? $limit : $numberOfFaqs,
                    'offset' => $offset
                ]
            ];

            $view = $this->view($data, Codes::HTTP_OK);
        } else {
            $view = $this->view([], Codes::HTTP_NO_CONTENT);
        }

        return $this->handleView($view);
    }

    /**
     * Get one F.A.Q. item
     *
     * GET /api/faqs/1
     *
     * @param Faq $faq Faq
     *
     * @return Response
     *
     * @Rest\Get("/{id}")
     *
     * @ParamConverter("id", class="AppBundle:Faq")
     */
    public function getAction(Faq $faq)
    {
        $data = [
            'faq' => $faq
        ];

        $view = $this->view($data, Codes::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Create a new F.A.Q. item
     *
     * POST /api/faqs
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Rest\Post("")
     */
    public function createAction(Request $request)
    {
        $faq = new Faq();

        $form = $this->createForm(new FaqType(), $faq);

        $data = $request->request->all();

        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();

            $data = ['faq' => $faq];
            $view = $this->view($data, Codes::HTTP_CREATED);

            return $this->handleView($view);
        }

        return $this->handleView($this->view($form, Codes::HTTP_BAD_REQUEST));
    }

    /**
     * Update an existed F.A.Q. item
     *
     * PUT /api/faqs/1
     *
     * @param Faq     $faq     Faq
     * @param Request $request Request
     *
     * @return Response
     *
     * @Rest\Put("/{id}")
     *
     * @ParamConverter("id", class="AppBundle:Faq")
     */
    public function updateAction(Faq $faq, Request $request)
    {
        $form = $this->createForm(new FaqType(), $faq);

        $data = $request->request->all();

        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();

            $data = ['faq' => $faq];
            $view = $this->view($data, Codes::HTTP_CREATED);

            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);

        return $this->handleView($view);
    }

    /**
     * Delete an existed F.A.Q. item
     *
     * DELETE /api/faqs/1
     *
     * @param int $id ID
     *
     * @return Response
     *
     * @Rest\Delete("/{id}")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $faq = $em->getRepository('AppBundle:Faq')->find($id);

        // If F.A.Q. item still exists then remove it
        if ($faq instanceof Faq) {
            $em->remove($faq);
            $em->flush();
        }

        $view = $this->view(null, Codes::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }

    /**
     * Delete all F.A.Q. items
     *
     * DELETE /api/faqs
     *
     * @return Response
     *
     * @Rest\Delete("")
     */
    public function deleteAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $faqRepository = $em->getRepository('AppBundle:Faq');

        $faqs = $faqRepository->findAll();
        if (count($faqs) > 0) {
            foreach ($faqs as $faq) {
                $em->remove($faq);
            }
            $em->flush();
        }

        return $this->handleView($this->view(null, Codes::HTTP_NO_CONTENT));
    }
}
