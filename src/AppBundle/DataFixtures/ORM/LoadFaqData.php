<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Faq;
use AppBundle\Entity\Translation\FaqTranslation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load FAQ fixtures
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 */
class LoadFaqData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faq1 = (new Faq())
            ->setQuestion('How i could ask some question?')
            ->setAnswer('Just type the text.')
            ->setEnabled(true)
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('question')
                    ->setContent('')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('answer')
                    ->setContent('')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('question')
                    ->setContent('')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('answer')
                    ->setContent('')
            );
        $manager->persist($faq1);

        $faq2 = (new Faq())
            ->setQuestion('What is F.A.Q.?')
            ->setAnswer('It`s friendly answer question.')
            ->setEnabled(true)
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('question')
                    ->setContent('')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('answer')
                    ->setContent('')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('question')
                    ->setContent('')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('answer')
                    ->setContent('')
            );
        $manager->persist($faq2);

        $manager->flush();
    }
}
