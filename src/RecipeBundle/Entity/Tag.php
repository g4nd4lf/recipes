<?php

namespace RecipeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="RecipeBundle\Repository\TagRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Tag
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=150, nullable=false)
     */
    private $name;

    /**
     * @var TagGroup $tagGroup
     *
     * @ORM\ManyToOne(targetEntity="TagGroup")
     * @ORM\JoinColumn(name="tag_group_id", referencedColumnName="id")
     */
    private $tagGroup;

    /**
     * @var Collection $recipes
     *
     * @ORM\ManyToMany(targetEntity="Recipe", mappedBy="tags")
     */
    private $recipes;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->recipes = new ArrayCollection;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set tagGroup
     *
     * @param TagGroup $tagGroup
     *
     * @return Tag
     */
    public function setTagGroup(TagGroup $tagGroup = null)
    {
        $this->tagGroup = $tagGroup;

        return $this;
    }

    /**
     * Get tagGroup
     *
     * @return TagGroup
     */
    public function getTagGroup()
    {
        return $this->tagGroup;
    }

    /**
     * Add recipe
     *
     * @param Tag $recipe
     *
     * @return Tag
     */
    public function addRecipe(Tag $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param Tag $recipe
     */
    public function removeRecipe(Tag $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Returns string representation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
