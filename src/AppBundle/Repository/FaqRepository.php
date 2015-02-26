<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Faq;

/**
 * Class Faq Repository
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class FaqRepository extends EntityRepository
{
    /**
     * Get all enabled
     *
     * @param int  $offset Offset
     * @param null $limit  Limit
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

        return $qb->getQuery()->getResult();
    }

    /**
     * Get Faq list
     *
     * @param int  $offset
     * @param null $limit
     *
     * @return Faq[]
     */
    public function getFaqList($offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->select('f.id')
            ->addSelect('f.question')
            ->addSelect('f.answer')
            ->addSelect('f.enabled')
            ->setFirstResult($offset);;

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
