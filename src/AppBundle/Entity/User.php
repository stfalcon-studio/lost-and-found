<?php

namespace AppBundle\Entity;

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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * Get ID
     *
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * To string
     */
    function __toString()
    {
        return $this->getFullName() ?: 'New User';
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
     * @return mixed Facebook ID
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set Facebook ID
     *
     * @param mixed $facebookId Facebook ID
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
