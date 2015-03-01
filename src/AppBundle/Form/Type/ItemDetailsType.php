<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * ItemDetailsType
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class ItemDetailsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('save', 'submit', [
                'label' => 'Contact with author',
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
        return 'item_details';
    }
}
