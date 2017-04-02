<?php

namespace RecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag Group
 *
 * @ORM\Table(name="tag_group")
 * @ORM\Entity()
 */
class TagGroup
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
     * Tag Group constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime;
        $this->updatedAt = new \DateTime;
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
     * @return TagGroup
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
     * Returns string representation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
