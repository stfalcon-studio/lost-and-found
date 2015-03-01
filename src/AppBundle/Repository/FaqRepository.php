<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Faq;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FaqRepository
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class FaqRepository extends EntityRepository
{
    /**
     * Find enabled F.A.Q. items with limit and offset
     *
     * @param integer $limit  Limit
     * @param integer $offset Offset
     *
     * @return array
     */
    public function findEnabledWithLimitAndOffset($limit = 10, $offset = 0)
    {
        $qb = $this->createQueryBuilder('f');

        return $qb->where($qb->expr()->eq('f.enabled', true))
                  ->setMaxResults($limit)
                  ->setFirstResult($offset)
                  ->getQuery()
                  ->getResult();
    }

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
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param int  $id
     * @param int  $offset
     * @param null $limit
     *
     * @return Faq
     */
    public function getFaqById($id, $offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->select('f.id')
            ->addSelect('f.question')
            ->addSelect('f.answer')
            ->addSelect('f.enabled')
            ->where($qb->expr()->eq('f.id', ':id'))
            ->setParameter('id', $id)
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
