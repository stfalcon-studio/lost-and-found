<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Item;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Doctrine\ORM\EntityRepository;

/**
 * Class ItemRepository
 *
 * @author svatok13 <svatok13@gmail.com>
 */
class ItemRepository extends EntityRepository
{
    /**
     * Get active lost items
     *
     * @param integer $offset Offset
     * @param integer $limit  Limit
     *
     * @return Item[]
     */
    public function getActiveLostItem($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where($qb->expr()->eq('i.status', ':status'))
           ->andWhere($qb->expr()->eq('i.type', ':type'))
           ->andWhere($qb->expr()->eq('i.moderated', true))
           ->setParameters([
               'type'   => ItemTypeType::LOST,
               'status' => ItemStatusType::ACTIVE
           ])
           ->orderBy('i.createdAt', 'DESC')
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Get active Found items
     *
     * @param integer $offset Offset
     * @param integer $limit  Limit
     *
     * @return Item[]
     */
    public function getActiveFoundItem($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where($qb->expr()->eq('i.status', ':status'))
           ->andWhere($qb->expr()->eq('i.type', ':type'))
           ->andWhere($qb->expr()->eq('i.moderated', true))
           ->setParameters([
               'type'   => ItemTypeType::FOUND,
               'status' => ItemStatusType::ACTIVE
           ])
           ->orderBy('i.createdAt', 'DESC')
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Get lost points
     *
     * @param integer $offset Offset
     * @param integer $limit  Limit
     *
     * @return array
     */
    public function getLostPoints($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i.latitude')
            ->addSelect('i.longitude')
            ->addSelect('i.category')
            ->where($qb->expr()->eq('i.moderated', true))
            ->andWhere($qb->expr()->eq('i.type', ':type'))
            ->setParameter('type', ItemTypeType::LOST)
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Get found points
     *
     * @param integer $offset Offset
     * @param integer $limit  Limit
     *
     * @return array
     */
    public function getFoundPoints($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i.latitude')
           ->addSelect('i.longitude')
           ->addSelect('IDENTITY(i.category) AS categoryId')
           ->where($qb->expr()->eq('i.moderated', true))
           ->andWhere($qb->expr()->eq('i.type', ':type'))
           ->setParameter('type', ItemTypeType::FOUND)
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param integer $id
     *
     * @return array
     */
    public function getFoundPoint($id)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i.latitude')
            ->addSelect('i.longitude')
            ->where($qb->expr()->eq('i.moderated', true))
            ->andWhere($qb->expr()->eq('i.type', ':type'))
            ->andWhere($qb->expr()->eq('i.id', ':id'))
            ->setParameters([
                'type' => ItemTypeType::FOUND,
                'id' => $id,
            ]);

        return $qb->getQuery()->getResult();
    }
}
