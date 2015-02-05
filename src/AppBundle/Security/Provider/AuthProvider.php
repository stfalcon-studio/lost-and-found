<?php

namespace AppBundle\Security\Provider;

use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;

/**
 * Class AuthProvider
 */
class AuthProvider extends BaseProvider
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * Constructor
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userManager->findUserBy([
                'facebookId' => $response->getUsername()
        ]);

        if ($user instanceof User) {
            return $user;
        }

        // Try to create user
        $user = $this->createUserFromResponse($response);

        return $user;
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return User
     */
    private function createUserFromResponse(UserResponseInterface $response)
    {
        $email = $response->getEmail() ?: $response->getUsername() . '@example.com';

        /** @var User $user */
        $user = $this->userManager->createUser();

        $user->setUsername($response->getUsername())
             ->setFullName($response->getRealName())
             ->setEmail($email)
             ->setEnabled(true)
             ->setPlainPassword(uniqid())
             ->setFacebookId($response->getUsername())
             ->setFacebookAccessToken($response->getAccessToken());

        $this->userManager->updateUser($user);

        return $user;
    }
}
