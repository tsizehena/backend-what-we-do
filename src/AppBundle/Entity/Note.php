<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 */
class Note
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $value;

    /**
     * @var string
     */
    private $description;

    /**
     * Many Notes have One Community.
     */
    private $community;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Note
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Note
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set community
     *
     * @param \AppBundle\Entity\Community $community
     * @return Note
     */
    public function setCommunity(\AppBundle\Entity\Community $community = null)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \AppBundle\Entity\Community 
     */
    public function getCommunity()
    {
        return $this->community;
    }

    public function __toString() {
        return $this->description;
    }
}
