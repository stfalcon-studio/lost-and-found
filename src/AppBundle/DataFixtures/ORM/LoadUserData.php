<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * Load User fixtures
 *
 * @author Andrew Prohorych <prohorovychua@gmail.com>
 */
class LoadUserData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        //Random user 1
        $user1 = (new User())
            ->setUsername('tewtret')
            ->setEnabled(true)
            ->setEmail('sdfadfasd')
            ->setPlainPassword('qweytrsfgjf')
            ->setFacebookAccessToken('sdfsdfsdf')
            ->setFullName('Test')
            ->getFacebookId('1');
        $this->setReference('rndUser1', $user1);
        $manager->persist($user1);

        $manager->flush();
    }
}