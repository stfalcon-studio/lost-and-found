<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Item;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ItemRepository
 *
 * @author svatok13 <svatok13@gmail.com>
 */
class ItemRepository extends EntityRepository
{
    /**
     * Get active lost items array
     *
     * @param integer $offset
     * @param integer $limit
     *
     * @return array|Item[]
     */
    public function getActiveLostItem($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where('i.status = :status')
            ->andWhere('i.type = :type')
            ->setParameters([
                'type' => ItemTypeType::LOST,
                'status' => ItemStatusType::ACTIVE
            ])
            ->orderBy('i.createdAt', 'DESC')
            ->setFirstResult($offset);

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Get active lost items array
     *
     * @param integer $offset
     * @param integer $limit
     *
     * @return array|Item[]
     */
    public function getActiveFoundItem($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');


        $qb->where('i.status = :status')
            ->andWhere('i.type = :type')
            ->setParameters([
                'type' => ItemTypeType::FOUND,
                'status' => ItemStatusType::ACTIVE
            ])
            ->orderBy('i.createdAt', 'DESC')
            ->setFirstResult($offset);

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}