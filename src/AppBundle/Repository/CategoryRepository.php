<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Gedmo\Tree\Entity\Repository\MaterializedPathRepository;

/**
 * Class CategoryRepository
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Yuri Svatok    <svatok13@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class CategoryRepository extends MaterializedPathRepository
{
    /**
     * Get categories
     *
     * @param int  $offset
     * @param null $limit
     *
     * @return Category[]
     */
    public function getParentCategories($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->where($qb->expr()->eq('c.enabled', true))
           ->andWhere($qb->expr()->isNull('c.parent'))
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
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

        $qb->where($qb->expr()->eq('c.enabled', true))
           ->andWhere($qb->expr()->isNull('c.parent'))
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Find active categories
     *
     * @param int|null $limit  Limit
     * @param int      $offset Offset
     *
     * @return Category[]
     */
    public function findActiveCategories($limit = null, $offset = 0)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->where($qb->expr()->eq('c.enabled', true))
           ->andWhere($qb->expr()->isNull('c.parent'))
           ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
                  ->getResult();
    }
}
