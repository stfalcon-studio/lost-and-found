<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * UserItemRequest entity
 *
 * @author Artem Genvald  <GenvaldArtem@gmail.com>
 * @author Yuri Svatok    <Svatok13@gmail.com>
 * @author Oleg Kachinsky <LogansOleg@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRequestRepository")
 * @ORM\Table(name="item_requests",
 *          uniqueConstraints={@ORM\UniqueConstraint(name="unique_request", columns={"item_id", "user_id"})})
 */
class ItemRequest
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
     * Get created at
     *
     * @return \DateTime
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
