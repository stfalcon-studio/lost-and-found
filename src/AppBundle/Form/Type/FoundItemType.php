<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\DBAL\Types\ItemTypeType;
use Symfony\Component\Form\AbstractType;

/**
 * Class FoundItemType
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class FoundItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                'label'    => 'Категорія',
                'class'    => 'AppBundle\Entity\Category',
                'property' => 'title',
            ])
            ->add('title', 'text', [
                'label' => 'Назва',
            ])
            ->add('type', 'hidden', [
                'label' => 'Тип',
                'data'  => ItemTypeType::FOUND,
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
        return 'found_item';
    }
}
