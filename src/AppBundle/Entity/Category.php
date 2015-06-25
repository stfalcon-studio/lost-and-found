<?php
/*
 * This file is part of the "Lost and Found" project
 *
 * (c) Stfalcon.com <info@stfalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Translation\CategoryTranslation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category Entity
 *
 * @author Artem Genvald      <genvaldartem@gmail.com>
 * @author Yuri Svatok        <svatok13@gmail.com>
 * @author Andrew Prohorovych <prohorovychua@gmail.com>
 * @author Oleg Kachinsky     <logansoleg@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 *
 * @Gedmo\Loggable
 * @Gedmo\Tree(type="materializedPath")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\CategoryTranslation")
 *
 * @Vich\Uploadable
 */
class Category implements Translatable
{
    use TimestampableEntity;

    /**
     * @var int $id ID
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title Title
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Length(min="1", max="255")
     *
     * @Gedmo\Versioned
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var Collection|Item[] $items Items
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="category", cascade={"persist", "remove"}, orphanRemoval=true)
     *
     * @Assert\Type(type="object")
     */
    private $items;

    /**
     * @var boolean $enabled Enabled
     *
     * @ORM\Column(type="boolean")
     *
     * @Gedmo\Versioned
     */
    private $enabled = false;

    /**
     * @var File $imageFile Image file
     *
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @var string $imageName Image name
     *
     * @ORM\Column(type="string", length=255, name="image_name", nullable=true)
     *
     * @Gedmo\Versioned
     */
    private $imageName;

    /**
     * @var string $path Path
     *
     * @ORM\Column(type="string", length=3000, nullable=true)
     *
     * @Gedmo\TreePath
     * @Gedmo\Versioned
     */
    private $path;

    /**
     * @var string $pathSource Path source
     *
     * @ORM\Column(type="string", length=3000, nullable=true)
     *
     * @Gedmo\TreePathSource
     * @Gedmo\Versioned
     */
    private $pathSource;

    /**
     * @var Category $parent Parent category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     *
     * @Gedmo\TreeParent
     * @Gedmo\Versioned
     */
    private $parent;

    /**
     * @var int $level Level
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Gedmo\TreeLevel
     * @Gedmo\Versioned
     */
    private $level;

    /**
     * @var Collection|Category[] $children Children categories
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $children;

    /**
     * @var string $locale Required for Translatable behaviour
     *
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @var Collection|CategoryTranslation[] $translations Translations
     *
     * @Assert\Type(type="object")
     *
     * @ORM\OneToMany(
     *      targetEntity="AppBundle\Entity\Translation\CategoryTranslation",
     *      mappedBy="object",
     *      cascade={"persist", "remove"},
     *      orphanRemoval=true
     * )
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items        = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?: 'New Category';
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
     * Get items
     *
     * @return Item[]|Collection Items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set items
     *
     * @param Item[]|Collection $items Items
     *
     * @return $this
     */
    public function setItems(Collection $items)
    {
        foreach ($items as $item) {
            $item->setCategory($this);
        }
        $this->items = $items;

        return $this;
    }

    /**
     * Add item
     *
     * @param Item $item Item
     *
     * @return $this
     */
    public function addItem(Item $item)
    {
        $this->items->add($item->setCategory($this));

        return $this;
    }

    /**
     * Remove item
     *
     * @param Item $item Item
     *
     * @return $this
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    /**
     * Is enabled?
     *
     * @return boolean Is enabled?
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled Enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get image file
     *
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set image file
     *
     * @param File $imageFile Image file
     *
     * @return $this
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get image name
     *
     * @return string Image name
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set image name
     *
     * @param string $imageName Image name
     *
     * @return $this
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Category|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent category
     *
     * @param Category $parent Parent category
     *
     * @return $this
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get path
     *
     * @return string Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string $path Path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path source
     *
     * @return string Path source
     */
    public function getPathSource()
    {
        return $this->pathSource;
    }

    /**
     * Set path source
     *
     * @param string $pathSource Path source
     *
     * @return $this
     */
    public function setPathSource($pathSource)
    {
        $this->pathSource = $pathSource;

        return $this;
    }

    /**
     * Get level
     *
     * @return int Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param int $level level
     *
     * @return $this
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get children
     *
     * @return Category Children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set children
     *
     * @param Category $children children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;

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
     * Get translations
     *
     * @return Collection|CategoryTranslation[] Translations
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set translations
     *
     * @param Collection|CategoryTranslation[] $translations Translations
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
     * Add translation
     *
     * @param CategoryTranslation $translation Translation
     *
     * @return $this
     */
    public function addTranslation(CategoryTranslation $translation)
    {
        $this->translations->add($translation->setObject($this));

        return $this;
    }

    /**
     * Remove translation
     *
     * @param CategoryTranslation $translation Translation
     *
     * @return $this
     */
    public function removeTranslation(CategoryTranslation $translation)
    {
        $this->translations->removeElement($translation);

        return $this;
    }
}
