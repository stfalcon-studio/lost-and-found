<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\ItemAreaTypeType;
use AppBundle\DBAL\Types\ItemStatusType;
use AppBundle\Model\UserManageableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AppAssert;

/**
 * Item Entity
 *
 * @author Logans <Logansoleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 * @ORM\Table(name="items")
 * @ORM\HasLifecycleCallbacks
 *
 * @AppAssert\CheckItem()
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
     * @var boolean $active Active
     *
     * @ORM\Column(name="active", type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $active = true;

    /**
     * @var \DateTime|null $date
     *
     * @ORM\Column(type="date")
     *
     * @Gedmo\Versioned
     *
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @var Collection|ItemPhoto[] $items Items
     *
     * @Gedmo\TreePathSource
     *
     * @ORM\OneToMany(targetEntity="ItemPhoto", mappedBy="photos", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @ORM\JoinColumn(onDelete="CASCADE")
     */

    private $photos;

    /**
     * @var User $createdBy Created by
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="items")
     * @ORM\JoinColumn(name="createdBy", referencedColumnName="id", nullable=false)
     *
     * @Gedmo\Versioned
     *
     * @Assert\NotNull()
     */
    private $createdBy;

    /**
     * @var boolean $moderated
     *
     * @ORM\Column(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $moderated = false;

    /**
     * @var \DateTime $moderatedAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $moderatedAt;

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
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
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
     * @return \DateTime
     */
    public function getModeratedAt()
    {
        return $this->moderatedAt;
    }

    /**
     * Set moderated at
     *
     * @param \DateTime $moderatedAt
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
     * Get items
     *
     * @return ItemPhoto[]|Collection ItemPhotos
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set items
     *
     * @param ItemPhoto[]|Collection $itemPhotos ItemPhotos
     *
     * @return $this
     */
    public function setPhotos(Collection $itemPhotos)
    {
        foreach ($itemPhotos as $photo) {
            $photo->setItem($this);
        }
        $this->photos = $itemPhotos;

        return $this;
    }

    /**
     * Add photo
     *
     * @param ItemPhoto $itemPhoto
     *
     * @return $this
     */
    public function addPhoto(ItemPhoto $itemPhoto)
    {
        $this->photos->add($itemPhoto->setItem($this));

        return $this;
    }

    /**
     * Remove photo
     *
     * @param ItemPhoto $itemPhoto
     *
     * @return $this
     */
    public function removePhoto(ItemPhoto $itemPhoto)
    {
        $this->photos->removeElement($itemPhoto);

        return $this;
    }
}
