<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Item;
use AppBundle\Entity\User;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

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
               'status' => ItemStatusType::ACTUAL
           ])
           ->orderBy('i.createdAt', 'DESC')
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Get active found items
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
               'status' => ItemStatusType::ACTUAL
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

        $qb
            ->select('i.latitude')
            ->addSelect('i.longitude')
            ->addSelect('i.title AS itemTitle')
            ->addSelect('IDENTITY(i.category) AS categoryId')
            ->addSelect('i.date')
            ->addSelect('c.title')
            ->innerJoin('i.category', 'c', 'WITH', 'i.category = c.id')
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

        $qb
            ->select('i.latitude')
            ->addSelect('i.id')
            ->addSelect('i.longitude')
            ->addSelect('i.title AS itemTitle')
            ->addSelect('IDENTITY(i.category) AS categoryId')
            ->addSelect('i.date')
            ->addSelect('c.title')
            ->innerJoin('i.category', 'c', 'WITH', 'i.category = c.id')
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
     * Get user items
     *
     * @param User   $user       User
     * @param string $itemStatus Item status
     * @param string $itemType   Item type
     *
     * @return array
     */
    public function getUserItems(User $user, $itemStatus, $itemType)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where($qb->expr()->eq('i.createdBy', ':user'))
           ->andWhere($qb->expr()->eq('i.status', ':status'))
           ->andWhere($qb->expr()->eq('i.type', ':type'))
           ->setParameters([
               'user'   => $user,
               'status' => $itemStatus,
               'type'   => $itemType
           ]);

        return $qb->getQuery()->getResult();
    }
}
