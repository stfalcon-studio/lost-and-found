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
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
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
                'class'         => 'AppBundle\Entity\Category',
                'property'      => 'title',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('c');

                    return $qb->where($qb->expr()->eq('c.enabled', true));
                },
                'translation_domain' => 'main-page'
            ])
            ->add('title', 'text', [
                'translation_domain' => 'main-page'
            ])
            ->add('type', 'hidden', [
                'data'  => ItemTypeType::FOUND,
                'translation_domain' => 'main-page'
            ])
            ->add('latitude', 'hidden')
            ->add('active', 'hidden', [
                'data'  => true,
            ])
            ->add('longitude', 'hidden')
            ->add('areaType', 'hidden')
            ->add('description', 'textarea', [
                'translation_domain' => 'main-page'
            ])
            ->add('date', 'date', [
                'widget' => 'single_text',
                'translation_domain' => 'main-page'
            ])
            ->add('photos', 'collection', [
                'type'         => 'photo',
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
                'translation_domain' => 'main-page'
            ])
            ->add('save', 'submit', [
                'label' => 'Create',
                'attr'  => [
                    'class' => 'btn-success'
                ],
                'translation_domain' => 'main-page'
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
