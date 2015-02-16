<?php

namespace AppBundle\EventListener;

use AppBundle\Event\AddUserEditEvent;
use AppBundle\Model\UserManageableInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Item;

/**
 * Class AddUserEditListener
 *
 * @package AppBundle\Entity
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
    }
}
