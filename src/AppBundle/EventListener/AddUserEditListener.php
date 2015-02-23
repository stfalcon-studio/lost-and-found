<?php

namespace AppBundle\EventListener;

use AppBundle\Event\AddUserEditEvent;
use AppBundle\Model\UserManageableInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class AddUserEditListener
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class AddUserEditListener
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param AddUserEditEvent $args
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function onItemEdit(AddUserEditEvent $args)
    {
        $tokenStorage = $args->getTokenStorage();
        $item = $args->getItem();

        if ($item instanceof UserManageableInterface) {
            $user = $tokenStorage->getToken()->getUser();

            $item->setCreatedBy($user);
        }
        $item->setModerated(false);
    }
}
