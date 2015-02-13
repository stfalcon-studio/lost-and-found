<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\FAQ;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load FAQ fixtures
 */
class LoadFAQData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $question1 = (new FAQ())
            ->setQuestion('How i could ask some question?')
            ->setAnswer('Just type the text.');
        $manager->persist($question1);

        $question2 = (new FAQ())
            ->setQuestion('What is FAQ?')
            ->setAnswer('It`s friendly answer question.');
        $manager->persist($question2);

        $manager->flush();
    }
}
