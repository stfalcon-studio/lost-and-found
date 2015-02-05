<?php
/**
 * Created by PhpStorm.
 * User: svatok
 * Date: 04.02.15
 * Time: 15:45
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Category;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\DBAL\Types\ItemTypeType;
use Doctrine\ORM\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @author svatok13
 */
class CategoryRepository extends EntityRepository
{
    /**
     * @return Category[]
     */
    public function getAllEnabled()
    {
        $qb = $this->createQueryBuilder('c');
//
//        return $qb->getQuery()->getResult();

        $y =  $qb
            ->where($qb->expr()->eq('c.enabled', true))
            ->getQuery()->getResult();

        return $y;
    }
}