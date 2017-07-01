<?php

namespace RecipeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="RecipeBundle\Repository\RecipeRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Recipe
{
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $summary
     *
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $summary;

    /**
     * @var string $method
     *
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $method;

    /**
     * @var string $ingredients
     *
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $ingredients;

    /**
     * @var integer $servings
     *
     * @ORM\Column(type="smallint", nullable=false, options={"default":1})
     */
    private $servings;

    /**
     * @var integer $prepTime
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $prepTime;

    /**
     * @var integer $cookingTime
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $cookingTime;

    /**
     * @var Collection $tags
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="recipes")
     */
    private $tags;

    /**
     * Recipe constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection;
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
     * @return Recipe
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
     * Set summary
     *
     * @param string $summary
     *
     * @return Recipe
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set method
     *
     * @param string $method
     *
     * @return Recipe
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set ingredients
     *
     * @param string $ingredients
     *
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set servings
     *
     * @param integer $servings
     *
     * @return Recipe
     */
    public function setServings($servings)
    {
        $this->servings = $servings;

        return $this;
    }

    /**
     * Get servings
     *
     * @return integer
     */
    public function getServings()
    {
        return $this->servings;
    }

    /**
     * Set prepTime
     *
     * @param integer $prepTime
     *
     * @return Recipe
     */
    public function setPrepTime($prepTime)
    {
        $this->prepTime = $prepTime;

        return $this;
    }

    /**
     * Get prepTime
     *
     * @return integer
     */
    public function getPrepTime()
    {
        return $this->prepTime;
    }

    /**
     * Set cookingTime
     *
     * @param integer $cookingTime
     *
     * @return Recipe
     */
    public function setCookingTime($cookingTime)
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    /**
     * Get cookingTime
     *
     * @return integer
     */
    public function getCookingTime()
    {
        return $this->cookingTime;
    }

    /**
     * Add tag
     *
     * @param Tag $tag
     *
     * @return Recipe
     */
    public function addTag(Tag $tag)
    {
        $tag->addRecipe($this);
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $tag->removeRecipe($this);
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
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
