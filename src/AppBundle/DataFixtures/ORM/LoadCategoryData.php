<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Translation\CategoryTranslation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load Category fixtures
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Yuri Svatok    <svatok13@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 */
class LoadCategoryData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $keys = (new Category())
            ->setLocale('en')
            ->setTitle('Keys')
            ->setEnabled(true)
            ->setImageName('keys.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Ключі')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Ключи')
            );
        $this->setReference('category-keys', $keys);
        $manager->persist($keys);

        $phone = (new Category())
            ->setLocale('en')
            ->setTitle('Phone')
            ->setEnabled(true)
            ->setImageName('Phone-icon.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Телефон')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Телефон')
            );
        $this->setReference('category-phone', $phone);
        $manager->persist($phone);

        $documents = (new Category())
            ->setLocale('en')
            ->setTitle('Documents')
            ->setEnabled(true)
            ->setImageName('documents.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Документи')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Документы')
            );
        $this->setReference('category-documents', $documents);
        $manager->persist($documents);

        $clothes = (new Category())
            ->setLocale('en')
            ->setTitle('Clothes')
            ->setEnabled(true)
            ->setImageName('clothes.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Одяг')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Одежда')
            );
        $this->setReference('category-clothes', $clothes);
        $manager->persist($clothes);

        $jewelry = (new Category())
            ->setLocale('en')
            ->setTitle('Jewelry')
            ->setEnabled(true)
            ->setImageName('jewels.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Ювелірні вироби')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Ювелирные изделия')
            );
        $this->setReference('category-jewelry', $jewelry);
        $manager->persist($jewelry);

        $miscellaneous = (new Category())
            ->setLocale('en')
            ->setTitle('Miscellaneous')
            ->setEnabled(true)
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Різне')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Разное')
            );
        $this->setReference('category-miscellaneous', $miscellaneous);
        $manager->persist($miscellaneous);

        $animals = (new Category())
            ->setLocale('en')
            ->setTitle('Animals')
            ->setEnabled(true)
            ->setImageName('animals.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Тварини')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Животные')
            );
        $this->setReference('category-animals', $animals);
        $manager->persist($animals);

        $wallets = (new Category())
            ->setLocale('en')
            ->setTitle('Wallets')
            ->setEnabled(true)
            ->setImageName('wallet.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Гаманці')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Кошельки')
            );
        $this->setReference('category-wallets', $wallets);
        $manager->persist($wallets);

        $dogs = (new Category())
            ->setLocale('en')
            ->setTitle('Dogs')
            ->setEnabled(true)
            ->setParent($animals)
            ->setImageName('dogs.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Собаки')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Собаки')
            );
        $this->setReference('category-dogs', $dogs);
        $manager->persist($dogs);

        $cats = (new Category())
            ->setLocale('en')
            ->setTitle('Cats')
            ->setEnabled(true)
            ->setParent($animals)
            ->setImageName('cats.png')
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('uk')
                    ->setField('title')
                    ->setContent('Коти')
            )
            ->addTranslation(
                (new CategoryTranslation())
                    ->setLocale('ru')
                    ->setField('title')
                    ->setContent('Коты')
            );
        $this->setReference('category-cats', $cats);
        $manager->persist($cats);

        $manager->flush();
    }
}
