<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 */
class Event
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * Many Events have One Community.
     */
    private $community;

    /**
     *  Many Events have Many Choices.
     * @var \Doctrine\Common\Collections\ArrayCollection();
     */
    private $choices;

    /**
     *  Many Events have Many Participants
     *  @var \Doctrine\Common\Collections\ArrayCollection();
     */
    private $participants;

    public function __construct()
    {
        $this->days = new \Doctrine\Common\Collections\ArrayCollection();
        $this->choices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
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
     * @var \DateTime
     */
    private $campaign_begin;


    /**
     * Set campaign_begin
     *
     * @param \DateTime $campaignBegin
     * @return Event
     */
    public function setCampaignBegin($campaignBegin)
    {
        $this->campaign_begin = $campaignBegin;

        return $this;
    }

    /**
     * Get campaign_begin
     *
     * @return \DateTime 
     */
    public function getCampaignBegin()
    {
        return $this->campaign_begin;
    }
    /**
     * @var \DateTime
     */
    private $campaign_end;


    /**
     * Set campaign_end
     *
     * @param \DateTime $campaignEnd
     * @return Event
     */
    public function setCampaignEnd($campaignEnd)
    {
        $this->campaign_end = $campaignEnd;

        return $this;
    }

    /**
     * Get campaign_end
     *
     * @return \DateTime 
     */
    public function getCampaignEnd()
    {
        return $this->campaign_end;
    }

    /**
     * Set community
     *
     * @param \AppBundle\Entity\Community $community
     * @return Event
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

    /**
     * Add participants
     *
     * @param \AppBundle\Entity\Participant $participants
     * @return Event
     */
    public function addParticipant(\AppBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;

        return $this;
    }

    /**
     * Remove participants
     *
     * @param \AppBundle\Entity\Participant $participants
     */
    public function removeParticipant(\AppBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Add choices
     *
     * @param \AppBundle\Entity\Choice $choices
     * @return Event
     */
    public function addChoice(\AppBundle\Entity\Choice $choices)
    {
        $this->choices[] = $choices;

        return $this;
    }

    /**
     * Remove choices
     *
     * @param \AppBundle\Entity\Choice $choices
     */
    public function removeChoice(\AppBundle\Entity\Choice $choices)
    {
        $this->choices->removeElement($choices);
    }

    /**
     * Get choices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChoices()
    {
        return $this->choices;
    }
}
