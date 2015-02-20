<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Faq;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load FAQ fixtures
 *
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 */
class LoadFaqData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $question1 = (new Faq())
            ->setQuestion('How i could ask some question?')
            ->setAnswer('Just type the text.')
            ->setEnabled(true);
        $manager->persist($question1);

        $question2 = (new Faq())
            ->setQuestion('What is F.A.Q.?')
            ->setAnswer('It`s friendly answer question.')
            ->setEnabled(true);
        $manager->persist($question2);

        $manager->flush();
    }
}
