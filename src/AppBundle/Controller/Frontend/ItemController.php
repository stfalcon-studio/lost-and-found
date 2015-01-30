<?php
/**
 * Created by PhpStorm.
 * User: logans
 * Date: 30.01.15
 * Time: 12:14
 */

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ItemController
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class ItemController extends Controller
{
    /**
     * @var object
     */
    protected $item;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->item = new Item();
    }

    /**
     * @Route("/lost_item", name="lost_item")
     *
     * @param Request $request
     * @return Response
     */
    public function createLostForm(Request $request)
    {
        $form = $this->createFormBuilder($this->item)
            ->setMethod('post')
                ->add('title', 'text', [
                    'label' => 'Назва',
                ])
                ->add('category', 'entity', [
                    'label'    => 'Категорія',
                    'class'    => 'AppBundle\Entity\Category',
                    'property' => 'title',
                ])
                ->add('latitude', null, [
                    'label' => 'Тут має бути карта (Latitude/Longitude)',
                ])
                ->add('description', 'textarea', [
                    'label' => 'Опис',
                ])
                ->add('save', 'submit', [
                    'label' => 'Create',
                ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(':frontend/default:lost_item.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/found_item", name="found_item")
     *
     * @param Request $request
     * @return Response
     */
    public function createFoundForm(Request $request)
    {
        $form = $this->createFormBuilder($this->item)
            ->setMethod('post')
                ->add('title', 'text', [
                    'label' => 'Назва',
                ])
                ->add('category', 'entity', [
                    'label'    => 'Категорія',
                    'class'    => 'AppBundle\Entity\Category',
                    'property' => 'title',
                ])
                ->add('latitude', null, [
                    'label' => 'Тут має бути карта (Latitude/Longitude)',
                ])
                ->add('description', 'textarea', [
                    'label' => 'Опис',
                ])
                ->add('save', 'submit', [
                    'label' => 'Create',
                ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render(':frontend/default:found_item.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}