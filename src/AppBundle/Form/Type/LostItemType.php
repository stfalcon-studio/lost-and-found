<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\DBAL\Types\ItemTypeType;
use Symfony\Component\Form\AbstractType;
/**
 * Class LostItemType
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class LostItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                'class'    => 'AppBundle\Entity\Category',
                'property' => 'title',
                'label'    => 'Категорія',
            ])
            ->add('title', 'text', [
                'label' => 'Назва',
            ])
            ->add('type', 'hidden', [
                'label' => 'Тип',
                'data'  => ItemTypeType::LOST,
            ])
            ->add('latitude', 'text', [
                'label' => 'Latitude',
            ])
            ->add('longitude', 'text', [
                'label' => 'Longitude'
            ])
            ->add('description', 'textarea', [
                'label' => 'Опис',
            ])
            ->add('date', 'date', [
                'label' => 'Дата',
            ])
            ->add('save', 'submit', [
                'label' => 'Create',
            ])
            ->getForm();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lost_item';
    }
}
