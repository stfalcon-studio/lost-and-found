<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

/**
 * Load User fixtures
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
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

        // Admin user
        $adminUser = (new User())
            ->setUsername('Admin User')
            ->setEnabled(true)
            ->setEmail('admin_user@facebook')
            ->setRoles(['ROLE_ADMIN'])
            ->setPlainPassword('qwerty')
            ->setFullName('Admin User')
            ->setFacebookId('FacebookClientId')
            ->setFacebookAccessToken('FacebookClientSecret');
        $this->setReference('user-admin', $adminUser);
        $manager->persist($adminUser);

        $manager->flush();
    }
}
