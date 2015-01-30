<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\ItemStatusType;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;


/**
 * Item Entity
 *
 * @author Logans <Logansoleg@gmail.com>
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="items")
 */
class Item
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
     */
    private $category;

    /**
     * @var string $title Title
     *
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @var float $latitude Latitude
     *
     * @ORM\Column(type="decimal", precision=9, scale=6)
     */
    private $latitude;

    /**
     * @var float $longitude Longitude
     *
     * @ORM\Column(type="decimal", precision=9, scale=6)
     */
    private $longitude;

    /**
     * @var array $type Type
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\ItemTypeType")
     *
     * @ORM\Column(name="type", type="ItemTypeType", nullable=false)
     */
    private $type;

    /**
     * @var string $description Description
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var array $area Area
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $area;

    /**
     * @var array $status Status
     *
     * @DoctrineAssert\Enum(entity="AppBundle\DBAL\Types\ItemStatusType")
     *
     * @ORM\Column(name="status", type="ItemStatusType", nullable=false)
     */
    private $status = ItemStatusType::ACTIVE;

    /**
     * __toString method
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
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
