<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Category;

/**
 * ItemsListType
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class ItemsListType extends AbstractType
{
    /**
     * @var Category $categories
     */
    private $categories;

    /**
     * @param Category $categories
     */
    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', 'choice', [
                'choices' => $this->categories,
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
                    'class' => 'btn-success'
                ]
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
