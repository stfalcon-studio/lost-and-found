<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
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
                'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('c');

                    return $qb->where($qb->expr()->eq('c.enabled', true));
                },
            ])
            ->add('title', 'text', [
                'label' => 'Назва',
            ])
            ->add('type', 'hidden', [
                'label' => 'Тип',
                'data'  => ItemTypeType::LOST,
            ])
            ->add('latitude', 'hidden', [
                'label' => 'Latitude',
            ])
            ->add('longitude', 'hidden', [
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
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lost_item';
    }
}
