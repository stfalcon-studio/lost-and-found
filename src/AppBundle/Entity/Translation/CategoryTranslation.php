<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * CategoryTranslation Entity
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 *
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(name="category_translations",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="category_translation_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */
class CategoryTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
