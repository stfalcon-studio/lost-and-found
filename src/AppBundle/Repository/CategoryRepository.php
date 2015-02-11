<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use Gedmo\Tree\Entity\Repository\MaterializedPathRepository;

/**
 * Class CategoryRepository
 *
 * @author svatok13
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class CategoryRepository extends MaterializedPathRepository
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
}
