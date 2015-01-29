<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Item;
use AppBundle\DBAL\Types\ItemType;
use AppBundle\DBAL\Types\ItemStatus;

/**
 * Class LoadItemData
 */
class LoadItemData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return ['AppBundle\DataFixtures\ORM\LoadCategoryData'];
    }


    /**
     * {@inheritDoc} Create and load item fixtures to database
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $categoryPhone = $this->getReference('category-item');
        $phone = (new Item())
            ->setTitle("Телефон Google Nexus 5")
            ->setCategory($categoryPhone)
            ->setLatitude(49.437764)
            ->setLongitude(27.005755)
            ->setType(ItemType::LOST)
            ->setDescription("Загубив телефон Google Nexus 5. Потрібна допомога за винагороду.")
            ->setStatus(ItemStatus::ACTIVE);

        $manager->persist($phone);

        $categoryKeys = $this->getReference('category-keys');
        $keys = (new Item())
            ->setTitle("Ключі від квартири")
            ->setCategory($categoryKeys)
            ->setLatitude(51.437764)
            ->setLongitude(23.005755)
            ->setType(ItemType::LOST)
            ->setDescription("Втратив ключі від квартири.")
            ->setStatus(ItemStatus::ACTIVE);

        $manager->persist($keys);

        $categoryItem = $this->getReference('category-item');
        $hat = (new Item())
            ->setTitle("Шапка")
            ->setCategory($categoryItem)
            ->setLatitude(50.437764)
            ->setLongitude(25.005755)
            ->setType(ItemType::LOST)
            ->setDescription("Загубив улюблену шапку червоного кольору.")
            ->setStatus(ItemStatus::ACTIVE);

        $manager->persist($hat);

        $manager->flush();
    }
}