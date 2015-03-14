<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @var EntityManager $entityManager Entity manager
     */
    private $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $em Entity manager
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param AddUserEditEvent $args Arguments
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
