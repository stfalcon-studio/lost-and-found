<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Item;
use AppBundle\Entity\User;
use AppBundle\Entity\ItemRequest;

/**
 * ItemRequestRepository
 *
 * @author Logans <Logansoleg@gmail.com>
 */
class ItemRequestRepository extends EntityRepository
{
    /**
     * @param Item $item
     * @param User $user
     *
     * @return ItemRequest
     */
    public function findUserItemRequest(Item $item, User $user)
    {
        $qb = $this->createQueryBuilder('ir');

        $qb
            ->where($qb->expr()->eq('ir.item', ':item'))
            ->andWhere($qb->expr()->eq('ir.user', ':user'))
            ->setParameters([
                'item' => $item,
                'user' => $user,
            ]);

        return $qb->getQuery()->getScalarResult();
    }
}
