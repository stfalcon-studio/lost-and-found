<?php

namespace AppBundle\Form\Type;

use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Event\AddUserEditEvent;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class FoundItemType
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class FoundItemType extends AbstractType
{
    /**
     * @var TokenStorageInterface $tokenStorage Token storage
     */
    private $tokenStorage;

    /**
     * Constructor
     *
     * @param TokenStorageInterface    $tokenStorage
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(TokenStorageInterface $tokenStorage, EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                'class'    => 'AppBundle\Entity\Category',
                'property' => 'title',
                'query_builder' => function(EntityRepository $er) {
                    $qb = $er->createQueryBuilder('c');

                    return $qb->where($qb->expr()->eq('c.enabled', true));
                },
            ])
            ->add('title', 'text')
            ->add('type', 'hidden', [
                'data'  => ItemTypeType::FOUND,
            ])
            ->add('latitude', 'hidden')
            ->add('active', 'hidden', [
                'data'  => true,
            ])
            ->add('longitude', 'hidden')
            ->add('areaType', 'hidden')
            ->add('description', 'textarea')
            ->add('date', 'date', [
                'widget' => 'single_text'
            ])
            ->add('photos', 'collection', [
                'type'         => 'photo',
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
            ->add('save', 'submit', [
                'label' => 'Create',
                'attr'  => [
                    'class' => 'btn-success'
                ]
            ]);
        $tokenStorage = $this->tokenStorage;
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($tokenStorage) {
            $item = $event->getData();
            $this->eventDispatcher->dispatch(FormEvents::SUBMIT, new AddUserEditEvent($tokenStorage, $item));
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'found_item';
    }
}
