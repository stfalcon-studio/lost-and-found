<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Category;

/**
 * Load Category fixtures
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class LoadCategoryData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $keys = (new Category())
            ->setTitle('Ключі')
            ->setEnabled(true)
            ->setImageName("http://lost-and-found.work/images/categories/keys.png");
        $this->setReference('category-keys', $keys);
        $manager->persist($keys);

        $phone = (new Category())
            ->setTitle('Телефон')
            ->setEnabled(true)
            ->setImageName("http://lost-and-found.work/images/categories/Phone-icon.png");
        $this->setReference('category-phone', $phone);
        $manager->persist($phone);

        $documents = (new Category())
            ->setTitle('Документи')
            ->setEnabled(true);
        $this->setReference('category-documents', $documents);
        $manager->persist($documents);

        $clothes = (new Category())
            ->setTitle('Одяг')
            ->setEnabled(true);
        $this->setReference('category-clothes', $clothes);
        $manager->persist($clothes);

        $manager->flush();
    }
}
