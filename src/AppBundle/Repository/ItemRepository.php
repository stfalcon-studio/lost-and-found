<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Item;
use AppBundle\Entity\User;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Doctrine\ORM\EntityRepository;

/**
 * Class ItemRepository
 *
 * @author Artem Genvald      <GenvaldArtem@gmail.com>
 * @author Yuri Svatok        <Svatok13@gmail.com>
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 * @author Oleg Kachinsky     <LogansOleg@gmail.com>
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

        return $qb->where($qb->expr()->eq('i.createdBy', ':user'))
                  ->andWhere($qb->expr()->eq('i.status', ':status'))
                  ->andWhere($qb->expr()->eq('i.type', ':type'))
                  ->andWhere($qb->expr()->eq('i.active', ':active'))
                  ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
                  ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
                  ->setParameters([
                      'user'      => $user,
                      'status'    => $itemStatus,
                      'type'      => $itemType,
                      'active'    => $activeStatus,
                      'deleted'   => $deleted,
                      'moderated' => $moderated
                  ])
                  ->getQuery()
                  ->getResult();
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

        return $qb->where($qb->expr()->eq('i.createdBy', ':user'))
                  ->andWhere($qb->expr()->eq('i.active', ':active'))
                  ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
                  ->setParameters([
                      'user'    => $user,
                      'active'  => $active,
                      'deleted' => $deleted
                  ])
                  ->getQuery()
                  ->getResult();
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

        return $qb->where($qb->expr()->eq('i.createdBy', ':user'))
                  ->andWhere($qb->expr()->eq('i.active', ':active'))
                  ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
                  ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
                  ->setParameters([
                      'user'      => $user,
                      'active'    => true,
                      'deleted'   => false,
                      'moderated' => $moderated
                  ])
                  ->getQuery()
                  ->getResult();
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
     * @param User   $user User
     * @param string $type Type
     *
     * @return integer
     */
    public function getUserItemsCountByType(User $user, $type)
    {
        $qb = $this->createQueryBuilder('i');

        return $qb->select('COUNT(i)')
                  ->where($qb->expr()->eq('i.createdBy', ':user'))
                  ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
                  ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
                  ->andWhere($qb->expr()->eq('i.active', ':active'))
                  ->andWhere($qb->expr()->eq('i.type', ':type'))
                  ->setParameters([
                      'user'      => $user,
                      'moderated' => true,
                      'deleted'   => false,
                      'type'      => $type,
                      'active'    => true,
                  ])
                  ->getQuery()
                  ->getSingleScalarResult();
    }

    /**
     * @param User    $user      User
     * @param boolean $moderated Moderated
     *
     * @return integer
     */
    public function getUserItemsCountByModerate(User $user, $moderated)
    {
        $qb = $this->createQueryBuilder('i');

        return $qb->select('COUNT(i)')
                  ->where($qb->expr()->eq('i.createdBy', ':user'))
                  ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
                  ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
                  ->setParameters([
                      'user'      => $user,
                      'moderated' => $moderated,
                      'deleted'   => false,
                  ])
                  ->getQuery()
                  ->getSingleScalarResult();
    }

    /**
     * @param User    $user   User
     * @param boolean $active Active
     *
     * @return integer
     */
    public function getUserItemsCountByActivate(User $user, $active)
    {
        $qb = $this->createQueryBuilder('i');

        return $qb->select('COUNT(i)')
                  ->where($qb->expr()->eq('i.createdBy', ':user'))
                  ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
                  ->andWhere($qb->expr()->eq('i.deleted', ':deleted'))
                  ->andWhere($qb->expr()->eq('i.active', ':active'))
                  ->setParameters([
                      'user'      => $user,
                      'moderated' => true,
                      'deleted'   => false,
                      'active'    => $active
                  ])
                  ->getQuery()
                  ->getSingleScalarResult();
    }

    /**
     * Get item requests
     *
     * @param Item $item Item
     *
     * @return array
     */
    public function getItemRequests(Item $item)
    {
        $qb = $this->createQueryBuilder('i');

        $qb->select('i.title')
           ->addSelect('ir.createdAt as createdAt')
           ->addSelect('us.fullName as userName')
           ->addSelect('us.facebookId')
           ->join('i.userRequests', 'ir')
           ->join('ir.user', 'us')
           ->where($qb->expr()->eq('i.id', ':id'))
           ->setParameter('id', $item->getId());

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Get lost items order by category
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return array
     */
    public function getLostItemsOrderByCategory(\DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('COUNT(i) AS totalItems')
            ->addSelect('c.title')
            ->addSelect('i.createdAt')
            ->join('i.category', 'c')
            ->where($qb->expr()->eq('i.type', ':type'))
            ->groupBy('i.category')
            ->setParameter('type', ItemTypeType::LOST);

        if (!is_null($dateFrom) && !is_null($dateTo)) {
            $from = $dateFrom->format('Y-m-d 00:00:00');
            $to = $dateTo->format('Y-m-d 23:59:59');

            $qb
                ->andWhere($qb->expr()->between('i.createdAt', ':from', ':to'))
                ->setParameter('from', $from)
                ->setParameter('to', $to);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Get found items order by category
     *
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return array
     */
    public function getFoundItemsOrderByCategory(\DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('COUNT(i) AS totalItems')
            ->addSelect('c.title')
            ->addSelect('i.createdAt')
            ->join('i.category', 'c')
            ->where($qb->expr()->eq('i.type', ':type'))
            ->groupBy('i.category')
            ->setParameter('type', ItemTypeType::FOUND);

        if (null !== $dateFrom && null !== $dateTo) {
            $from = $dateFrom->format('Y-m-d 00:00:00');
            $to = $dateTo->format('Y-m-d 23:59:59');

            $qb
                ->andWhere($qb->expr()->between('i.createdAt', ':from', ':to'))
                ->setParameter('from', $from)
                ->setParameter('to', $to);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Find moderated item by id
     *
     * @param integer $id
     *
     * @return Item
     */
    public function findModeratedItemById($id)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->select('i')
            ->where($qb->expr()->eq('i.id', ':id'))
            ->andWhere($qb->expr()->eq('i.moderated', ':moderated'))
            ->setParameters([
                'id' => $id,
                'moderated' => true,
            ]);

        return $qb->getQuery()->getSingleResult();
    }
}
