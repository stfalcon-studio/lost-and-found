<?php

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use AppBundle\Model\UserManageableInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\DBAL\Types\ItemTypeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class LostItemType
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class LostItemType extends AbstractType
{
    /**
     * @var TokenStorageInterface $tokenStorage Token storage
     */
    private $tokenStorage;

    /**
     * Constructor
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                'class'         => 'AppBundle\Entity\Category',
                'property'      => 'title',
                'label'         => 'Категорія',
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
            ->add('active', 'hidden', [
                'label' => 'Активність',
                'data'  => true,
            ])
            ->add('latitude', 'hidden')
            ->add('longitude', 'hidden')
            ->add('area', 'hidden')
            ->add('areaType', 'text')
            ->add('description', 'textarea', [
                'label' => 'Опис',
            ])
            ->add('date', 'date', [
                'label' => 'Дата',
                'widget' => 'single_text'
            ])
            ->add('save', 'submit', [
                'label' => 'Create',
            ]);

        $tokenStorage = $this->tokenStorage;

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($tokenStorage) {
            $item = $event->getData();

            if ($item instanceof UserManageableInterface) {
                $user = $tokenStorage->getToken()->getUser();

                $item->setCreatedBy($user);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'lost_item';
    }
}
