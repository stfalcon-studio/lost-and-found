<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\Model\UserManageableInterface;
use AppBundle\Validator\Constraints as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item Entity
 *
 * @author Artem Genvald      <GenvaldArtem@gmail.com>
 * @author Yuri Svatok        <Svatok13@gmail.com>
 * @author Andrew Prohorovych <ProhorovychUA@gmail.com>
 * @author Oleg Kachinsky     <LogansOleg@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks
 *
 * @AppAssert\ItemArea()
 *
 * @Gedmo\Loggable
 */
class Item implements UserManageableInterface
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
     * @var Category $category Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="items")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     *
     * @Gedmo\Versioned
     *
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @var string $title Title
     *
     * @ORM\Column(type="string", length=120)
     *
     * @Gedmo\Versioned
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="50")
     * @Assert\Type(type="string")
     */
    private $title;

    /**
     * @var float $latitude Latitude
     *
     * @ORM\Column(type="decimal", precision=18, scale=15, nullable=true)
     *
     * @Gedmo\Versioned
     */
    private $latitude;

    /**
     * @var float $longitude Longitude
     *
     * @ORM\Column(type="decimal", precision=18, scale=15, nullable=true)
     *
     * @Gedmo\Versioned
     */
    private $longitude;

    /**
     * @var array $type Type
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\ItemTypeType")
     *
     * @ORM\Column(name="type", type="ItemTypeType", nullable=false)
     *
     * @Gedmo\Versioned
     */
    private $type;

    /**
     * @var string $description Description
     *
     * @ORM\Column(type="text")
     *
     * @Gedmo\Versioned
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(min="1", max="1000")
     */
    private $description;

    /**
     * @var array $area Area
     *
     * @ORM\Column(type="json_array", nullable=true)
     *
     * @Gedmo\Versioned
     */
    private $area;

    /**
     * @var array $areaType Area type
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\ItemAreaTypeType")
     *
     * @ORM\Column(name="areaType", type="ItemAreaTypeType", nullable=false)
     *
     * @Gedmo\Versioned
     */
    private $areaType;

    /**
     * @var array $status Status
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\ItemStatusType")
     *
     * @ORM\Column(name="status", type="ItemStatusType", nullable=false)
     *
     * @Gedmo\Versioned
     */
    private $status = ItemStatusType::ACTUAL;

    /**
     * @var boolean $active Is active?
     *
     * @ORM\Column(name="active", type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $active = true;

    /**
     * @var \DateTime|null $date Date
     *
     * @ORM\Column(type="date")
     *
     * @Gedmo\Versioned
     *
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var Collection|ItemRequest[] $userRequests userRequest
     *
     * @ORM\OneToMany(targetEntity="ItemRequest", mappedBy="item", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $userRequests;

    /**
     * @var Collection|ItemPhoto[] $photos Photos
     *
     * @ORM\OneToMany(targetEntity="ItemPhoto", mappedBy="item", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $photos;

    /**
     * @var User $createdBy Created by
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="items")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     *
     * @Gedmo\Versioned
     *
     * @Assert\NotNull()
     */
    private $createdBy;

    /**
     * @var boolean $moderated Is moderated?
     *
     * @ORM\Column(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $moderated = false;

    /**
     * @var \DateTime $moderatedAt Moderated at
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $moderatedAt;

    /**
     * @var \DateTime $activatedAt Activated at
     *
     * @ORM\Column(type = "datetime", nullable=true)
     */
    private $activatedAt;

    /**
     * @var boolean $deleted Is deleted?
     *
     * @ORM\Column(name="deleted", type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $deleted = false;

    /**
     * @var \DateTime $deletedAt Deleted at
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userRequests = new ArrayCollection();
        $this->photos       = new ArrayCollection();
    }
    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?: 'New Item';
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
     * Get title
     *
     * @return string Title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title Title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float Latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude Latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float Longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude Longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get type
     *
     * @return array Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param array $type Type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set active
     *
     * @param boolean $active Active
     *
     * @return $this
     */
    public function setActive($active)
    {
        if ($active) {
           $this->setActivatedAt(new \DateTime());
        }
        $this->active = $active;

        return $this;
    }

    /**
     * Get description
     *
     * @return string Description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get area
     *
     * @return array Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set area
     *
     * @param array $area Area
     *
     * @return $this
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get status
     *
     * @return string Status
     */
    public function getAreaType()
    {
        return $this->areaType;
    }

    /**
     * Set area type
     *
     * @param string $areaType Area type
     *
     * @return $this
     */
    public function setAreaType($areaType)
    {
        $this->areaType = $areaType;

        return $this;
    }

    /**
     * Get status
     *
     * @return string Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status Status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param Category $category Category
     *
     * @return $this
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date Date
     *
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return User CreatedBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdBy
     *
     * @param User $createdBy createdBy
     *
     * @return $this
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Is moderated
     *
     * @return boolean
     */
    public function isModerated()
    {
        return $this->moderated;
    }

    /**
     * Set moderated
     *
     * @param boolean $moderated Moderated
     *
     * @return $this
     */
    public function setModerated($moderated)
    {
        $this->moderated = $moderated;

        return $this;
    }

    /**
     * Get moderated at
     *
     * @return \DateTime Moderated at
     */
    public function getModeratedAt()
    {
        return $this->moderatedAt;
    }

    /**
     * Set moderated at
     *
     * @param \DateTime $moderatedAt Moderated at
     *
     * @return $this
     */
    public function setModeratedAt($moderatedAt)
    {
        $this->moderatedAt = $moderatedAt;

        return $this;
    }

    /**
     * Doctrine hook to set moderatedAt when item is moderated
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function postModerate()
    {
        if (true === $this->moderated) {
            $this->setModeratedAt(new \DateTime());
        }
    }

    /**
     * Get activated at
     *
     * @return \DateTime Activated at
     */
    public function getActivatedAt()
    {
        return $this->activatedAt;
    }

    /**
     * Set activated at
     *
     * @param \DateTime $activatedAt Activated at
     *
     * @return $this
     */
    public function setActivatedAt($activatedAt)
    {
        $this->activatedAt = $activatedAt;

        return $this;
    }

    /**
     * Get deleted at
     *
     * @return \DateTime Deleted at
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deleted at
     *
     * @param \DateTime $deletedAt
     *
     * @return $this
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Is delete
     *
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deleted at
     *
     * @param boolean $delete
     *
     * @return $this
     */
    public function setDeleted($delete)
    {
        if ($delete) {
           $this->setDeletedAt(new \DateTime());
        }
        $this->deleted = $delete;

        return $this;
    }

    /**
     * Get photos
     *
     * @return ItemPhoto[]|Collection Photos
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set photos
     *
     * @param ItemPhoto[]|Collection $photos Photos
     *
     * @return $this
     */
    public function setPhotos(Collection $photos)
    {
        foreach ($photos as $photo) {
            $photo->setItem($this);
        }
        $this->photos = $photos;

        return $this;
    }

    /**
     * Add photo
     *
     * @param ItemPhoto $photo Photo
     *
     * @return $this
     */
    public function addPhoto(ItemPhoto $photo)
    {
        $this->photos->add($photo->setItem($this));

        return $this;
    }

    /**
     * Remove photo
     *
     * @param ItemPhoto $photo Photo
     *
     * @return $this
     */
    public function removePhoto(ItemPhoto $photo)
    {
        $this->photos->removeElement($photo);

        return $this;
    }

    /**
     * Get userRequest
     *
     * @return ItemRequest[]|Collection UserItemRequest
     */
    public function getUserRequests()
    {
        return $this->userRequests;
    }

    /**
     * Set userRequests
     *
     * @param ItemRequest[]|Collection $userRequests
     *
     * @return $this
     */
    public function setUserRequests(Collection $userRequests)
    {
        foreach ($userRequests as $userRequest) {
            $userRequest->setItem($this);
        }
        $this->userRequests = $userRequests;

        return $this;
    }

    /**
     * Add userRequest
     *
     * @param ItemRequest $userRequest
     *
     * @return $this
     */
    public function addUserRequest(ItemRequest $userRequest)
    {
        $this->userRequests->add($userRequest->setItem($this));

        return $this;
    }

    /**
     * Remove userRequest
     *
     * @param ItemRequest $userRequest
     *
     * @return $this
     */
    public function removeUserRequest(ItemRequest $userRequest)
    {
        $this->userRequests->removeElement($userRequest);

        return $this;
    }

}
