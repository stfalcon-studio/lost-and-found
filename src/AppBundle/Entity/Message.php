<?php

namespace AppBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Message Entity
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 * @ORM\Table(name = "messages")
 *
 * @Gedmo\Loggable
 */
class Message
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
     * @var string $content Content
     *
     * @ORM\Column(type="string", length=120)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="50")
     * @Assert\Type(type="string")
     */
    private $content;

    /**
     * @var boolean $active Active
     *
     * @ORM\Column(name="active", type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $active = true;

    /**
     * @var User $sender
     *
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "sentMessages")
     * @ORM\JoinColumn(name = "sender", referencedColumnName = "id")
     *
     * @Gedmo\Versioned
     */
    private $sender;

    /**
     * @var User $receiver
     *
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "receiveMessages")
     * @ORM\JoinColumn(name = "receiver", referencedColumnName = "id")
     *
     * @Gedmo\Versioned
     */
    private $receiver;

    /**
     * @var boolean $deleted
     *
     * @ORM\Column(name="deleted", type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $deleted = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     *
     * @return $this
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     *
     * @return $this
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     *
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }
}
