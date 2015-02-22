<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Translation\FaqTranslation;
use AppBundle\Validator\Constraints as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Faq Entity
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FaqRepository")
 * @ORM\Table(name="faq")
 *
 * @Gedmo\Loggable
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\FaqTranslation")
 */
class Faq implements Translatable
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
     * @ORM\Column(type="string", length=200)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="200")
     * @Assert\Type(type="string")
     *
     * @Gedmo\Versioned
     * @Gedmo\Translatable()
     */
    private $question;

    /**
     * @var string $answer Answer
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="1000")
     * @Assert\Type(type="string")
     *
     * @Gedmo\Versioned
     * @Gedmo\Translatable()
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
     * @var string $locale Required for Translatable behaviour
     *
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @var Collection|FaqTranslation[] $translations Translations
     *
     * @Assert\Type(type="object")
     *
     * @ORM\OneToMany(
     *      targetEntity="AppBundle\Entity\Translation\FaqTranslation",
     *      mappedBy="object",
     *      cascade={"persist", "remove"},
     *      orphanRemoval=true
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

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
     * Get ID
     *
     * @return int ID
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

    /**
     * Get locale
     *
     * @return string Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set locale
     *
     * @param string $locale Locale
     *
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Set translations
     *
     * @param Collection|FaqTranslation[] $translations Translations
     *
     * @return $this
     */
    public function setTranslations($translations)
    {
        foreach ($translations as $translation) {
            $translation->setObject($this);
        }
        $this->translations = $translations;

        return $this;
    }

    /**
     * Get translations
     *
     * @return Collection|FaqTranslation[] Translations
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Add translation
     *
     * @param FaqTranslation $translation Translation
     *
     * @return $this
     */
    public function addTranslation(FaqTranslation $translation)
    {
        $this->translations->add($translation->setObject($this));

        return $this;
    }

    /**
     * Remove translation
     *
     * @param FaqTranslation $translation Translation
     *
     * @return $this
     */
    public function removeTranslation(FaqTranslation $translation)
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}
