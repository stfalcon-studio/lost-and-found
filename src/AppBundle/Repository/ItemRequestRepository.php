<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Item;
use AppBundle\Entity\ItemRequest;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class ItemRequestRepository
 *
 * @author Yuri Svatok    <svatok13@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
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
