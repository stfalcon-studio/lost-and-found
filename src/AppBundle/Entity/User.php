<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * User Entity
 *
 * @author svatok13 <svatok13@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
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
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $items;

    /**
     * @var Collection|UserActionLog[] $actionLogs Actionlog
     *
     * @ORM\OneToMany(targetEntity="UserActionLog", mappedBy="userId", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $actionLogs;

    /**
     * @var string $fullName Full name
     *
     * @ORM\Column(name="full_name", type="string", length=255, nullable=false)
     */
    private $fullName;

    /**
     * @var string $facebookId Facebook ID
     *
     * @ORM\Column(name="facebook_id", type="string", length=32, nullable=false)
     */
    private $facebookId;

    /**
     * @var string $facebookAccessToken Facebook access token
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $facebookAccessToken;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = new ArrayCollection();
        $this->actionLogs = new ArrayCollection();
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
}
