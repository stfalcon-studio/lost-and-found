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

/**
 * StatisticType
 *
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class StatisticType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', 'date', [
                'label'  => 'From',
                'widget' => 'single_text',
            ])
            ->add('to', 'date', [
                'label'  => 'To',
                'widget' => 'single_text',
            ])
            ->add('save', 'submit', [
                'label' => 'Filter',
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
        return 'statistic';
    }
}
