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

        $qb
            ->select('i.id')
            ->addSelect('i.title')
            ->addSelect('c.title as categoryTitle')
            ->where($qb->expr()->eq('i.status', ':status'))
            ->andWhere($qb->expr()->eq('i.type', ':type'))
            ->andWhere($qb->expr()->eq('i.moderated', true))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->join('i.category', 'c')
            ->setParameters([
                'type'   => ItemTypeType::LOST,
                'status' => ItemStatusType::ACTUAL,
                'deleted'=> false,
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

        $qb
            ->where($qb->expr()->eq('i.status', ':status'))
            ->andWhere($qb->expr()->eq('i.type', ':type'))
            ->andWhere($qb->expr()->eq('i.moderated', true))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->setParameters([
                'type'   => ItemTypeType::FOUND,
                'status' => ItemStatusType::ACTUAL,
                'deleted'=> false,
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
    public function getLostMarkers($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('i.id AS itemId')
            ->addSelect('i.latitude')
            ->addSelect('i.longitude')
            ->addSelect('i.area')
            ->addSelect('i.areaType')
            ->addSelect('i.title')
            ->addSelect('i.date')
            ->addSelect('c.id AS categoryId')
            ->join('i.category', 'c')
//            ->where($qb->expr()->eq('i.status', ':actual'))
            ->andWhere($qb->expr()->eq('i.type', ':lost'))
            ->andWhere($qb->expr()->eq('i.moderated', true))
            ->andWhere($qb->expr()->eq('i.active', true))
//            ->setParameters([
//                'actual' => ItemStatusType::ACTUAL,
//                'lost'  => ItemTypeType::FOUND,
//            ])
            ->setParameter('lost', ItemTypeType::LOST)
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
    public function getFoundMarkers($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('i.id AS itemId')
            ->addSelect('i.latitude')
            ->addSelect('i.longitude')
            ->addSelect('i.title')
            ->addSelect('i.date')
            ->addSelect('c.id AS categoryId')
            ->join('i.category', 'c')
//            ->where($qb->expr()->eq('i.status', ':actual'))
            ->andWhere($qb->expr()->eq('i.type', ':found'))
            ->andWhere($qb->expr()->eq('i.moderated', true))
            ->andWhere($qb->expr()->eq('i.active', true))
//            ->setParameters([
//                'actual' => ItemStatusType::ACTUAL,
//                'found'  => ItemTypeType::FOUND,
//            ])
            ->setParameter('found', ItemTypeType::FOUND)
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Get user items
     *
     * @param User    $user         User
     * @param string  $itemStatus   Item status
     * @param string  $itemType     Item type
     * @param boolean $activeStatus Active
     * @param boolean $deleted      Deleted
     * @param boolean $moderated    Moderated
     *
     * @return array
     */
    public function getUserItems(User $user, $itemStatus, $itemType, $activeStatus, $deleted, $moderated)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where($qb->expr()->eq('i.createdBy', ':user'))
            ->andWhere($qb->expr()->eq('i.status', ':status'))
            ->andWhere($qb->expr()->eq('i.type', ':type'))
            ->andWhere($qb->expr()->eq('i.active', ':active'))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
            ->setParameters([
                'user'   => $user,
                'status' => $itemStatus,
                'type'   => $itemType,
                'active' => $activeStatus,
                'deleted' => $deleted,
                'moderated' => $moderated,
            ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * Get user items
     *
     * @param User    $user    User
     * @param boolean $active  active
     * @param boolean $deleted Deleted
     *
     * @return array
     */
    public function getDeactivatedItems(User $user, $active, $deleted)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where($qb->expr()->eq('i.createdBy', ':user'))
           ->andWhere($qb->expr()->eq('i.active', ':active'))
           ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
           ->setParameters([
               'user'   => $user,
               'active' => $active,
               'deleted'=> $deleted
           ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * Get user items
     *
     * @param User    $user      User
     * @param boolean $moderated moderated
     *
     * @return array
     */
    public function getNotModeratedItems(User $user, $moderated)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->where($qb->expr()->eq('i.createdBy', ':user'))
            ->andWhere($qb->expr()->eq('i.active', ':active'))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
            ->setParameters([
                'user'   => $user,
                'active'   => true,
                'deleted' => false,
                'moderated' => $moderated,
            ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * Get lost items
     *
     * @param int  $offset
     * @param null $limit
     *
     * @return array
     */
    public function getLostItems($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('i.id')
            ->addSelect('i.title AS itemTitle')
            ->addSelect('c.title AS categoryTitle')
            ->addSelect('c.id AS categoryId')
            ->addSelect('i.latitude')
            ->addSelect('i.longitude')
            ->addSelect('i.area')
            ->addSelect('i.areaType')
            ->join('i.category', 'c')
            //->where($qb->expr()->eq('i.status', ':actual'))
            ->andWhere($qb->expr()->eq('i.type', ':found'))
            ->andWhere($qb->expr()->eq('i.moderated', true))
            //->andWhere($qb->expr()->eq('i.active', true))
            /*->setParameters([
                'actual' => ItemStatusType::ACTUAL,
                'found'  => ItemTypeType::FOUND,
            ])*/
            ->setParameter('found', ItemTypeType::LOST)
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Get found items
     *
     * @param int  $offset
     * @param null $limit
     *
     * @return array
     */
    public function getFoundItems($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('i.id')
            ->addSelect('i.title AS itemTitle')
            ->addSelect('c.title AS categoryTitle')
            ->addSelect('c.id AS categoryId')
            ->addSelect('i.latitude')
            ->addSelect('i.longitude')
            ->addSelect('i.area')
            ->addSelect('i.areaType')
            ->join('i.category', 'c')
            //->where($qb->expr()->eq('i.status', ':actual'))
            ->andWhere($qb->expr()->eq('i.type', ':found'))
            ->andWhere($qb->expr()->eq('i.moderated', true))
            //->andWhere($qb->expr()->eq('i.active', true))
            /*->setParameters([
                'actual' => ItemStatusType::ACTUAL,
                'found'  => ItemTypeType::FOUND,
            ])*/
            ->setParameter('found', ItemTypeType::FOUND)
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param User   $user
     * @param string $type
     *
     * @return integer
     */
    public function getUserItemsCountByType(User $user, $type)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('count(i)')
            ->where($qb->expr()->eq('i.createdBy', ':user'))
            ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->andWhere($qb->expr()->eq('i.active', ':active'))
            ->andWhere($qb->expr()->eq('i.type', ':type'))
            ->setParameters([
                'user' => $user,
                'moderated' => true,
                'deleted' => false,
                'type' => $type,
                'active' => true,
            ]);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param User    $user
     * @param boolean $moderated
     *
     * @return integer
     */
    public function getUserItemsCountByModerate(User $user, $moderated)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('count(i)')
            ->where($qb->expr()->eq('i.createdBy', ':user'))
            ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->setParameters([
                'user' => $user,
                'moderated' => $moderated,
                'deleted' => false,
            ]);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param User    $user
     * @param boolean $active
     *
     * @return integer
     */
    public function getUserItemsCountByActivate(User $user, $active)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('count(i)')
            ->where($qb->expr()->eq('i.createdBy', ':user'))
            ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
            ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
            ->andWhere($qb->expr()->eq('i.active', ':active'))
            ->setParameters([
                'user' => $user,
                'moderated' => true,
                'deleted' => false,
                'active' => $active,
            ]);

        return $qb->getQuery()->getSingleScalarResult();
    }
    /**
     * @param int $id
     *
     * @return array
     */
    public function getUserRequests($id)
    {
        $qb = $this->createQueryBuilder('i');
        $qb
            ->select('i.title')
            ->addSelect('ir.createdAt as createdAt')
            ->addSelect('us.fullName as user')
            ->innerJoin('i.userRequests', 'ir')
            ->innerJoin('ir.user', 'us')
            ->where($qb->expr()->eq('i.id', ':id'))
            ->setParameter('id', $id);

        return $qb->getQuery()->getArrayResult();
    }
}
