<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class LoginUserActionLog
 * @ORM\Table(name="user_item_requests")
 * @ORM\Entity
 */
class UserItemRequest
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
     * @var User $user User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="itemRequests", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $user;

    /**
     * @var Item $item Item
     *
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="userRequests", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $item;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

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
     * @param User $user user
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get item
     *
     * @return Item item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set item
     *
     * @param Item $item item
     *
     * @return $this
     */
    public function setItem(Item $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Sets createdAt.
     *
     * @param  \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
