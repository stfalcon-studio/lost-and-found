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
            ->setUsername('Test User')
            ->setEnabled(true)
            ->setEmail('test@localhost')
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('qwerty')
            ->setFullName('Test')
            ->setFacebookId('1')
            ->setFacebookAccessToken('sdfsdfsdf');
        $this->setReference('rndUser1', $user1);
        $manager->persist($user1);

        $manager->flush();
    }
}
