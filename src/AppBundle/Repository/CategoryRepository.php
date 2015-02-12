<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;
use AppBundle\DBAL\Types\ItemTypeType;

/**
 * Class CategoryRepository
 *
 * @author svatok13
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Get all enabled categories
     *
     * @return Category[]
     */
    public function getAllEnabled()
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->where($qb->expr()->eq('c.enabled', true))
                  ->getQuery()
                  ->getResult();
    }

    /**
     * @param int  $offset
     * @param null $limit
     *
     * @return array
     */
    public function getCategories($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->where($qb->expr()->eq('c.enabled', true))
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
