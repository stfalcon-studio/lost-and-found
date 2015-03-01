<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserActionLog Entity
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @author Yuri Svatok   <svatok13@gmail.com>
 *
 * @ORM\Table(name="user_log_actions")
 * @ORM\Entity
 */
class UserActionLog
{
    /**
     * @var int $id ID
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array $actionType Action type
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\UserActionType")
     *
     * @ORM\Column(type="UserActionType", nullable=false)
     */
    private $actionType;

    /**
     * @var User $user User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="actionLogs", cascade={"persist", "remove"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $user;

    /**
     * @var \DateTime $createdAt Created at
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get action type
     *
     * @return array Action type
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * Set action type
     *
     * @param array $actionType Action type
     *
     * @return $this
     */
    public function setActionType($actionType)
    {
        $this->actionType = $actionType;

        return $this;
    }

    /**
     * Get user
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
     * @param User $user User
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get created at
     *
     * @return \DateTime Created at
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created at
     *
     * @param \DateTime $createdAt Created at
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
