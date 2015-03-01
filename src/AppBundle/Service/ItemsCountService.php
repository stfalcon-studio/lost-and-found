<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\User;

/**
 * Class ItemsCountService
 *
 * @author Yuri Svatok <svatok13@gmail.com>
 */
class ItemsCountService
{
    /**
     * @var EntityManager $entityManager Entity manager
     */
    private $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $em Entity manager
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param User $user User
     *
     * @return array
     */
    public function getCount(User $user)
    {
        $repository = $this->entityManager->getRepository('AppBundle:Item');

        $foundCount = $repository->getUserItemsCountByType($user, ItemTypeType::FOUND);
        $lostCount  = $repository->getUserItemsCountByType($user, ItemTypeType::LOST);

        $notModeratedCount = $repository->getUserItemsCountByModerate($user, false);
        $notActiveCount    = $repository->getUserItemsCountByActivate($user, false);

        return [
            'lost'         => $lostCount,
            'found'        => $foundCount,
            'notModerated' => $notModeratedCount,
            'notActive'    => $notActiveCount
        ];
    }
}
