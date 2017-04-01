<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
{
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
     * @var string $summary
     *
     * @ORM\Column(name="summary", type="string", length=1024, nullable=true)
     */
    private $summary;

    /**
     * @var string $method
     *
     * @ORM\Column(name="method", type="string", length=65535, nullable=true)
     */
    private $method;

    /**
     * @var string $ingredients
     *
     * @ORM\Column(name="ingredients", type="string", length=65535, nullable=true)
     */
    private $ingredients;

    /**
     * @var integer $servings
     *
     * @ORM\Column(name="servings", type="smallint", nullable=false, options={"default":1})
     */
    private $servings;

    /**
     * @var integer $prepTime
     *
     * @ORM\Column(name="prepTime", type="smallint", nullable=true)
     */
    private $prepTime;

    /**
     * @var integer $cookingTime
     *
     * @ORM\Column(name="cookingTime", type="smallint", nullable=true)
     */
    private $cookingTime;

    /**
     * @var Collection $tags
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="recipes")
     * @ORM\JoinTable(name="recipe_tags")
     */
    private $tags;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    private $updatedAt;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Recipe
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
}
