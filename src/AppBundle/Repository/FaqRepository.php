<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Faq Repository
 *
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 */
class FaqRepository extends EntityRepository
{
    /**
     * @param int  $offset
     * @param null $limit
     *
     * @return Request
     */
    public function getAllEnabled($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->where($qb->expr()->eq('f.enabled', true))
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
