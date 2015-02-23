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
            ->setLocale('en')
            ->setQuestion('How i could ask some question?')
            ->setAnswer('Just type the text.')
            ->setEnabled(true)
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('question')
                    ->setContent('Як я можу написати питання?')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('answer')
                    ->setContent('Просто напиши текст.')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('question')
                    ->setContent('Как я могу задать вопрос?')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('answer')
                    ->setContent('Просто напиши текст.')
            );
        $manager->persist($faq1);

        $faq2 = (new Faq())
            ->setLocale('en')
            ->setQuestion('What is F.A.Q.?')
            ->setAnswer('It`s frequently answer question.')
            ->setEnabled(true)
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('question')
                    ->setContent('Що таке Ч.А.П.И.?')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('uk')
                    ->setField('answer')
                    ->setContent('Це питання, які часто задаються.')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('question')
                    ->setContent('Что такое Ч.А.В.О.?')
            )
            ->addTranslation(
                (new FaqTranslation())
                    ->setLocale('ru')
                    ->setField('answer')
                    ->setContent('Это часто задаваемые вопросы.')
            );
        $manager->persist($faq2);

        $manager->flush();
    }
}
