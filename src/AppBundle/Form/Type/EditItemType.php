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

use AppBundle\Event\AddUserEditEvent;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * EditItemType
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class EditItemType extends AbstractType
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
        $this->tokenStorage    = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                'class'         => 'AppBundle\Entity\Category',
                'choice_label'  => 'title',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('c');

                    return $qb->where($qb->expr()->eq('c.enabled', true));
                },
            ])
            ->add('title', 'text')
            ->add('type', 'hidden')
            ->add('latitude', 'hidden')
            ->add('longitude', 'hidden')
            ->add('areaType', 'hidden')
            ->add('description', 'textarea')
            ->add('date', 'date', [
                'widget' => 'single_text'
            ])
            ->add('area', 'hidden', [
                'required' => false,
            ])
            ->add('areaMap', 'area_map', [
                'mapped' => false,
             ])
            ->add('update', 'submit', [
                'attr'  => [
                    'class' => 'btn-success',
                ],
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
        return 'item_edit';
    }
}
