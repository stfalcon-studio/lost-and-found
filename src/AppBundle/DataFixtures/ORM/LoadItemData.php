<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Item;
use AppBundle\DBAL\Types\ItemType;
use AppBundle\DBAL\Types\ItemStatus;

/**
 * Class LoadItemData
 */
class LoadItemData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $item = (new Item())
            ->setTitle("Телефон Google Nexus 5")
            ->setLatitude(49.437764)
            ->setLongitude(27.005755)
            ->setType(ItemType::LOST)
            ->setDescription("Загубив телефон Google Nexus 5. Потрібна допомога за винагороду.")
            ->setStatus(ItemStatus::ACTIVE);

        $manager->persist($item);

        for ($i = 0; $i < 100; $i++) {
            $item = (new Item())
                ->setTitle($this->generateRandomString(rand(10, 30)))
                ->setLatitude(rand(0, 1000000) / 1000000 + $i)
                ->setLongitude(rand(0, 1000000) / 1000000 + $i)
                ->setType(ItemType::LOST)
                ->setDescription($this->generateRandomString(rand(10, 300)))
                ->setStatus(ItemStatus::ACTIVE);

            $manager->persist($item);
        }

        $manager->flush();
    }

    /**
     * @param int $length String generated length
     * @return string
     */
    private function generateRandomString($length = 100)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}