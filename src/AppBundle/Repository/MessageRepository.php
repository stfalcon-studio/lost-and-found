<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;
use AppBundle\Entity\Message;

/**
 * Class Faq Repository
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class MessageRepository extends EntityRepository
{
    /**
     * @param User $user
     * @param int  $offset
     * @param null $limit
     *
     * @return Message[]
     */
    public function getSendMessages(User $user, $offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->select('m.content')
            ->addSelect('m.id')
            ->addSelect('m.active')
            ->addSelect('m.createdAt')
            ->addSelect('u.fullName')
            ->join('m.receiver', 'u')
            ->where($qb->expr()->eq('m.sender', ':user'))
            ->andWhere($qb->expr()->eq('m.deleted', ':delete'))
            ->setParameters([
                'user' => $user,
                'delete' => false,
            ])
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param User $user
     * @param int  $offset
     * @param null $limit
     *
     * @return Message[]
     */
    public function getReceivedMessages(User $user, $offset = 0, $limit = null)
    {
        $qb = $this->createQueryBuilder('m');

        $qb
            ->select('m.content')
            ->addSelect('m.id')
            ->addSelect('u.fullName')
            ->addSelect('m.active')
            ->addSelect('m.createdAt')
            ->join('m.sender', 'u')
            ->where($qb->expr()->eq('m.receiver', ':user'))
            ->andWhere($qb->expr()->eq('m.deleted', ':delete'))
            ->setParameters([
                'user' => $user,
                'delete' => false,
            ])
            ->setFirstResult($offset);

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
