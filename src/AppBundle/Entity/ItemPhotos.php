<?php
/**
 * Created by PhpStorm.
 * User: svatok
 * Date: 28.01.15
 * Time: 17:39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ItemPhotos
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="ItemId")
 */

class ItemPhotos
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=50)
     * @var string $fileName
     */
    protected $fileName;
    /**
     * @ORM\Column(type="integer")
     * @var integer $itemId
     */
    protected $itemId;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return ItemPhotos
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     * @return ItemPhotos
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->itemId;
    }
}
