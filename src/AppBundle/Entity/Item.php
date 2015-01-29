<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types as Types;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;

/**
 * Class Item
 *
 * @author Logans <Logansoleg@gmail.com>
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="item")
 */
class Item
{
    /**
     * @var int $id
     *
     * @ORM\Column(type="integer")
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int $categoryId
     *
     * @ORM\Column(type="integer")
     */
    protected $categoryId;

    /**
     * @var string $title
     *
     * @ORM\Column(type="text")
     */
    protected $title;

    /**
     * @var float $latitude
     *
     * @ORM\Column(type="decimal", precision=9, scale=6)
     */
    protected $latitude;

    /**
     * @var float $longitude
     *
     * @ORM\Column(type="decimal", precision=9, scale=6)
     */
    protected $longitude;

    /**
     * @var array $type
     *
     * @DoctrineAssert\Enum(entity="Types\ItemType")
     *
     * @ORM\Column(name="type", type="ItemType", nullable=false)
     */
    protected $type;

    /**
     * @var string $description
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var array $area
     *
     * @ORM\Column(type="json_array")
     */
    protected $area;

    /**
     * @var array $status
     *
     * @DoctrineAssert\Enum(entity="Types\ItemStatus")
     *
     * @ORM\Column(name="status", type="ItemStatus", nullable=false)
     */
    protected $status;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return array
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param array $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}