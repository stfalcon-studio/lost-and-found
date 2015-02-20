<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * Load User fixtures
 *
 * @author Artem Genvald      <GenvaldArtem@gmail.com>
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 */
class LoadUserData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Simple user
        $simpleUser = (new User())
            ->setUsername('Simple User')
            ->setEnabled(true)
            ->setEmail('simple_user@facebook')
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('qwerty')
            ->setFullName('Simple User')
            ->setFacebookId('FacebookClientId')
            ->setFacebookAccessToken('FacebookClientSecret');
        $this->setReference('user-simple', $simpleUser);
        $manager->persist($simpleUser);

        $manager->flush();
    }
}
