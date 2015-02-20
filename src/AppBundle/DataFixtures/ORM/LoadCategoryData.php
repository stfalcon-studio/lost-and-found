<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load Category fixtures
 *
 * @author Artem Genvald  <GenvaldArtem@gmail.com>
 * @author Yuri Svatok    <Svatok13@gmail.com>
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 */
class LoadCategoryData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $keys = (new Category())
            ->setTitle('Keys')
            ->setEnabled(true)
            ->setImageName('keys.png');
        $this->setReference('category-keys', $keys);
        $manager->persist($keys);

        $phone = (new Category())
            ->setTitle('Phone')
            ->setEnabled(true)
            ->setImageName('Phone-icon.png');
        $this->setReference('category-phone', $phone);
        $manager->persist($phone);

        $documents = (new Category())
            ->setTitle('Documents')
            ->setEnabled(true);
        $this->setReference('category-documents', $documents);
        $manager->persist($documents);

        $clothes = (new Category())
            ->setTitle('Clothes')
            ->setEnabled(true);
        $this->setReference('category-clothes', $clothes);
        $manager->persist($clothes);

        $jewelry = (new Category())
            ->setTitle('Jewelry')
            ->setEnabled(true);
        $this->setReference('category-jewelry', $jewelry);
        $manager->persist($jewelry);

        $miscellaneous = (new Category())
            ->setTitle('Miscellaneous')
            ->setEnabled(true);
        $this->setReference('category-miscellaneous', $miscellaneous);
        $manager->persist($miscellaneous);

        $animals = (new Category())
            ->setTitle('Animals')
            ->setEnabled(true);
        $this->setReference('category-animals', $animals);
        $manager->persist($animals);

        $dogs = (new Category())
            ->setTitle('Dogs')
            ->setEnabled(true)
            ->setParent($animals);
        $this->setReference('category-dogs', $dogs);
        $manager->persist($dogs);

        $cats = (new Category())
            ->setTitle('Cats')
            ->setEnabled(true)
            ->setParent($animals);
        $this->setReference('category-cats', $cats);
        $manager->persist($cats);

        $manager->flush();
    }
}
