<?php
/**
 * This file is part of the "Lost and Found" project
 *
 * @copyright Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User Entity
 *
 * @author Artem Genvald  <genvaldartem@gmail.com>
 * @author Yuri Svatok    <svatok13@gmail.com>
 * @author Oleg Kachinsky <logansoleg@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    use TimestampableEntity;

    /**
     * @var int $id ID
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Collection|Item[] $items Items
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="createdBy", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $items;

    /**
     * @var Collection|UserActionLog[] $actionLogs Actionlog
     *
     * @ORM\OneToMany(targetEntity="UserActionLog", mappedBy="user", cascade={"persist", "remove"})
     */
    private $actionLogs;

    /**
     * @var Collection|ItemRequest[] $itemRequests Item request
     *
     * @ORM\OneToMany(targetEntity="ItemRequest", mappedBy="user", cascade={"persist", "remove"})
     */
    private $itemRequests;

    /**
     * @var string $fullName Full name
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $fullName;

    /**
     * @var string $facebookId Facebook ID
     *
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    private $facebookId;

    /**
     * @var string $facebookAccessToken Facebook access token
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $facebookAccessToken;

    /**
     * @var Collection|Message[] $receiveMessages ReceiveMessages
     *
     * @ORM\OneToMany(targetEntity = "Message", mappedBy = "receiver", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete = "CASCADE")
     *
     * @Assert\Type(type = "object")
     */
    private $receivedMessages;

    /**
     * @var Collection|Message[] $sentMessages SendMessages
     *
     * @ORM\OneToMany(targetEntity = "Message", mappedBy = "sender", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete = "CASCADE")
     *
     * @Assert\Type(type = "object")
     */
    private $sentMessages;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->items        = new ArrayCollection();
        $this->actionLogs   = new ArrayCollection();
        $this->itemRequests = new ArrayCollection();
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName() ?: 'New User';
    }

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
     * Get items
     *
     * @return Item[]|Collection Items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set items
     *
     * @param Item[]|Collection $items items
     *
     * @return $this
     */
    public function setItems(Collection $items)
    {
        foreach ($items as $item) {
            $item->setCreatedBy($this);
        }
        $this->items = $items;

        return $this;
    }

    /**
     * Add item
     *
     * @param Item $item Item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items->add($item->setCreatedBy($this));

        return $this;
    }

    /**
     * Remove item
     *
     * @param Item $item Item
     *
     * @return $this
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    /**
     * Get ActionLogs
     *
     * @return UserActionLog[]|Collection action logs
     */
    public function getActionLogs()
    {
        return $this->actionLogs;
    }

    /**
     * Set ActionLogs
     *
     * @param UserActionLog[]|Collection $actionLogs actionLogs
     *
     * @return $this
     */
    public function setActionLogs(Collection $actionLogs)
    {
        foreach ($actionLogs as $actionLog) {
            $actionLog->setUser($this);
        }
        $this->actionLogs = $actionLogs;

        return $this;
    }

    /**
     * Add actionLog
     *
     * @param UserActionLog $actionLog actionLog
     *
     * @return $this
     */
    public function addActionLog(UserActionLog $actionLog)
    {
        $this->actionLogs->add($actionLog->setUser($this));

        return $this;
    }

    /**
     * Remove actionLog
     *
     * @param UserActionLog $actionLog actionLog
     *
     * @return $this
     */
    public function removeActionLog(UserActionLog $actionLog)
    {
        $this->actionLogs->removeElement($actionLog);

        return $this;
    }

    /**
     * Get full name
     *
     * @return string Full name
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set full name
     *
     * @param string $fullName Full name
     *
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get Facebook ID
     *
     * @return string Facebook ID
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set Facebook ID
     *
     * @param string $facebookId Facebook ID
     *
     * @return $this
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get Facebook access token
     *
     * @return string Facebook access token
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set Facebook access token
     *
     * @param string $facebookAccessToken Facebook access token
     *
     * @return $this
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get itemRequests
     *
     * @return ItemRequest[]|Collection UserItemRequest
     */
    public function getItemRequests()
    {
        return $this->itemRequests;
    }

    /**
     * Set itemRequests
     *
     * @param ItemRequest[]|Collection $itemRequests
     *
     * @return $this
     */
    public function setUserRequests(Collection $itemRequests)
    {
        foreach ($itemRequests as $itemRequest) {
            $itemRequest->setUser($this);
        }
        $this->itemRequests = $itemRequests;

        return $this;
    }

    /**
     * Add itemRequest
     *
     * @param ItemRequest $itemRequest
     *
     * @return $this
     */
    public function addUserRequest(ItemRequest $itemRequest)
    {
        $this->itemRequests->add($itemRequest->setUser($this));

        return $this;
    }

    /**
     * Remove itemRequest
     *
     * @param ItemRequest $itemRequest
     *
     * @return $this
     */
    public function removeUserRequest(ItemRequest $itemRequest)
    {
        $this->itemRequests->removeElement($itemRequest);

        return $this;
    }

    /**
     * @return Message
     */
    public function getReceiveMessages()
    {
        return $this->receivedMessages;
    }

    /**
     * @param Message $receivedMessages
     *
     * @return $this
     */
    public function setReceiveMessages($receivedMessages)
    {
        $this->receivedMessages = $receivedMessages;

        return $this;
    }

    /**
     * @return Message
     */
    public function getSentMessages()
    {
        return $this->sentMessages;
    }

    /**
     * @param Message $sentMessages
     *
     * @return $this
     */
    public function setSentMessages($sentMessages)
    {
        $this->sentMessages = $sentMessages;

        return $this;
    }

    /**
     * Get roles as string
     *
     * @return string
     */
    public function getRolesAsString()
    {
        $roles = [];

        foreach ($this->getRoles() as $role) {
            $roles[] = $role;
        }

        $result = implode(', ', $roles);

        return $result;
    }
}
