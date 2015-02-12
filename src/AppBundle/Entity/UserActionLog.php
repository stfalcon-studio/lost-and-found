<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\DBAL\Types\UserActionType;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Class LoginUserActionLog
 * @ORM\Table(name="user_log_actions")
 * @ORM\Entity
 */
class UserActionLog
{
    use TimestampableEntity;

    /**
     * @var int $id ID
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array $actionType
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\UserActionType")
     *
     * @ORM\Column(name="action", type="UserActionType", nullable=false)
     *
     */
    private $actionType;

    /**
     * @var User $user User id
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="actionLogs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $user;

    /**
     * Get id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get actionType
     *
     * @return array ActionType
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * Set actionType
     *
     * @param array $actionType actionType
     *
     * @return $this
     */
    public function setActionType($actionType)
    {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * Get userId
     *
     * @return User User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}
