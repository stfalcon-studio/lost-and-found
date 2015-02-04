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
     * @return array
     */
    public function getAllModerated()
    {
        $result = [];

        $qb = $this->createQueryBuilder('c');

        $qb->select('c.id')
            ->addSelect('c.title')
            ->addSelect('c.imageName')
            ->where($qb->expr()->eq('c.enabled', true));

        $rawResult = $qb->getQuery()->getArrayResult();

        foreach ($rawResult as $item) {
            $result[$item['id']] = $item;
        }


        return $result;
    }
}