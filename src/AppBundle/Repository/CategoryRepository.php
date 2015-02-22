<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;
use AppBundle\DBAL\Types\ItemTypeType;
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
    public function getCategories($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->where($qb->expr()->eq('c.enabled', true))
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
