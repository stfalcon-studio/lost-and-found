<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class Faq Repository
 */
class FaqRepository extends EntityRepository
{
    /**
     * @param int  $offset
     * @param null $limit
     *
     * @return array
     */
    public function getAllFaq($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('F');

        $qb
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
