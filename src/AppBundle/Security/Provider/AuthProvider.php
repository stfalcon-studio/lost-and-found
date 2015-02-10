<?php

namespace AppBundle\Security\Provider;

use AppBundle\Entity\User;
use AppBundle\Event\AppEvents;
use AppBundle\Event\FacebookUserConnectedEvent;
use AppBundle\Event\NewUserRegisteredEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseProvider;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AuthProvider
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 */
class AuthProvider extends BaseProvider
{
    /**
     * @var UserManagerInterface $userManager User manager
     */
    protected $userManager;

    /**
     * @var EventDispatcherInterface $eventDispatcher eventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param UserManagerInterface     $userManager     User manager
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     */
    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->userManager     = $userManager;
        $this->eventDispatcher = $eventDispatcher;
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
     * Create user from response
     *
     * @param UserResponseInterface $response
     *
     * @return User
     */
    private function createUserFromResponse(UserResponseInterface $response)
    {
        /** @var User $user User */
        $user = $this->userManager->createUser();

        $user->setUsername($response->getUsername())
             ->setFullName($response->getRealName())
             ->setEmail($response->getEmail())
             ->setEnabled(true)
             ->setPlainPassword(uniqid())
             ->setFacebookId($response->getUsername())
             ->setFacebookAccessToken($response->getAccessToken());

        $this->eventDispatcher->dispatch(AppEvents::FACEBOOK_USER_CONNECTED, new FacebookUserConnectedEvent($user));

        $this->userManager->updateUser($user);

        return $user;
    }
}
