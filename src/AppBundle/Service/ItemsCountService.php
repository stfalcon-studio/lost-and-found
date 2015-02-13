<?php


namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\DBAL\Types\ItemTypeType;
use AppBundle\Entity\User;

/**
 * Class ItemsCountService
 *
 */
class ItemsCountService
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $em EntityManager
     */
    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getCount(User $user)
    {
        $repository = $this->entityManager->getRepository('AppBundle:Item');

        $foundCount = $repository->getUserItemsCountByType($user, ItemTypeType::FOUND);
        $lostCount = $repository->getUserItemsCountByType($user, ItemTypeType::LOST);
        $notModeratedCount = $repository->getUserItemsCountByModerate($user, false);
        $notActiveCount = $repository->getUserItemsCountByActivate($user, false);

        return [
            'lost' => $lostCount,
            'found' => $foundCount,
            'notModerated' => $notModeratedCount,
            'notActive' => $notActiveCount,
        ];
    }
}
