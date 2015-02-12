<?php

namespace AppBundle\Security\Provider;

use AppBundle\Entity\User;
use AppBundle\Entity\UserActionLog;
use AppBundle\DBAL\Types\UserActionType;
use AppBundle\Event\AppEvents;
use AppBundle\Event\FacebookUserConnectedEvent;
use Doctrine\ORM\EntityManager;
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
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * Constructor
     *
     * @param UserManagerInterface     $userManager     User manager
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     * @param EntityManager            $em
     */
    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $eventDispatcher, EntityManager $em)
    {
        $this->userManager     = $userManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $em;
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
            $actionLog = new UserActionLog();
            $actionLog->setActionType(UserActionType::LOGIN);
            $actionLog->setUser($user);
            $actionLog->setCreatedAt(new \DateTime('now'));

            $em = $this->entityManager;
            $em->persist($actionLog);
            $em->persist($user);
            $em->flush();

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
