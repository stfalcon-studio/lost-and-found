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
        $keys = (new Category())->setTitle('Ключі');
        $this->setReference('category-keys', $keys);
        $manager->persist($keys);

        $phone = (new Category())->setTitle('Телефон');
        $this->setReference('category-phone', $phone);
        $manager->persist($phone);

        $documents = (new Category())->setTitle('Документи');
        $this->setReference('category-documents', $documents);
        $manager->persist($documents);

        $clothes = (new Category())->setTitle('Одяг');
        $this->setReference('category-clothes', $clothes);
        $manager->persist($clothes);

        $manager->flush();
    }
}
