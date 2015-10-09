<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * ItemsListType
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class ItemsListType extends AbstractType
{
    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = $this->em->getRepository('AppBundle:Category')->findActiveCategories();

        $categoriesList = [];
        foreach ($categories as $category) {
            $categoriesList[$category->getId()] = $category->getTitle();
        }

        $builder
            ->add('categories', 'choice', [
                'choices' => $categoriesList,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('from', 'date', [
                'label'  => 'From',
                'widget' => 'single_text',
                'required' => false,
                'translation_domain' => 'main-page'
            ])
            ->add('to', 'date', [
                'label'  => 'To',
                'widget' => 'single_text',
                'required' => false,
                'translation_domain' => 'main-page'
            ])
            ->add('filter', 'submit', [
                'label' => 'Filter',
                'translation_domain' => 'main-page',
                'attr'  => [
                    'class' => 'btn-success',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'items_list_type';
    }
}
