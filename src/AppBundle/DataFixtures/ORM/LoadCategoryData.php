<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

/**
 * Class LoadItemData
 */
class LoadCategoryData extends AbstractFixture
{
    /**
     * {@inheritDoc} Create and load category fixtures to database
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $keys = (new Category())
            ->setTitle("Ключі");
        $this->setReference('category-keys', $keys);
        $manager->persist($keys);

        $toy = (new Category())
            ->setTitle("Іграшка");
        $this->setReference('category-toy', $toy);
        $manager->persist($toy);

        $item = (new Category())
            ->setTitle("Предмет");
        $this->setReference('category-item', $item);
        $manager->persist($item);

        $manager->flush();
    }
}