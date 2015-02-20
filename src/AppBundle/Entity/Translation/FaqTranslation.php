<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Entity Class Faq Translation
 *
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="faq_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="faq_translation_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 *
 */
class FaqTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Faq", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
