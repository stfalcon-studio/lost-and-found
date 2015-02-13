<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Faq Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FaqRepository")
 * @ORM\Table(name="faq")
 *
 * @Gedmo\Loggable
 */
class Faq
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
     * @var string $question Question
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="200")
     * @Assert\Type(type="string")
     */
    private $question;

    /**
     * @var string $answer Answer
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="1000")
     * @Assert\Type(type="string")
     */
    private $answer;


    /**
     * @var boolean $enabled Enabled
     *
     * @ORM\Column(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $enabled = true;

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getQuestion() ?: 'New Faq';
    }

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
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     *
     * @return $this
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     *
     * @return $this
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }


}
