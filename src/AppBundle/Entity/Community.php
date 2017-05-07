<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Community
 */
class Community
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
     * @var \Doctrine\Common\Collections\ArrayCollection();
     */
    private $organizers;

    /**
     *  Many Communities have Many Choices.
     * @var \Doctrine\Common\Collections\ArrayCollection();
     */
    private $choices;

    /**
     *  Many Communities have Many Participants
     *  @var \Doctrine\Common\Collections\ArrayCollection();
     */
    private $participants;

    /**
     * One Community has Many Notes
     * @var \Doctrine\Common\Collections\ArrayCollection();
     */
    private $notes;

    /**
     * One Community has Many Events.
     */
    private $events;

    /**
     * Community constructor.
     */
    public function __construct() {
        $this->organizers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->choices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Community
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
     * @return Community
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
     * Add choices
     *
     * @param \AppBundle\Entity\Choice $choices
     * @return Community
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

    /**
     * Add participants
     *
     * @param \AppBundle\Entity\Participant $participants
     * @return Community
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
     * Add organizers
     *
     * @param \Application\Sonata\UserBundle\Entity\User $organizers
     * @return Community
     */
    public function addOrganizer(\Application\Sonata\UserBundle\Entity\User $organizers)
    {
        $this->organizers[] = $organizers;

        return $this;
    }

    /**
     * Remove organizers
     *
     * @param \Application\Sonata\UserBundle\Entity\User $organizers
     */
    public function removeOrganizer(\Application\Sonata\UserBundle\Entity\User $organizers)
    {
        $this->organizers->removeElement($organizers);
    }

    /**
     * Get organizers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganizers()
    {
        return $this->organizers;
    }
    /**
     * @var integer
     */
    private $noteMin;

    /**
     * @var integer
     */
    private $noteMax;


    /**
     * Set noteMin
     *
     * @param integer $noteMin
     * @return Community
     */
    public function setNoteMin($noteMin)
    {
        $this->noteMin = $noteMin;

        return $this;
    }

    /**
     * Get noteMin
     *
     * @return integer 
     */
    public function getNoteMin()
    {
        return $this->noteMin;
    }

    /**
     * Set noteMax
     *
     * @param integer $noteMax
     * @return Community
     */
    public function setNoteMax($noteMax)
    {
        $this->noteMax = $noteMax;

        return $this;
    }

    /**
     * Get noteMax
     *
     * @return integer 
     */
    public function getNoteMax()
    {
        return $this->noteMax;
    }

    /**
     * Add notes
     *
     * @param \AppBundle\Entity\Note $notes
     * @return Community
     */
    public function addNote(\AppBundle\Entity\Note $notes)
    {
        $notes->setCommunity($this);
        $this->notes[] = $notes;

        return $this;
    }

    /**
     * Remove notes
     *
     * @param \AppBundle\Entity\Note $notes
     */
    public function removeNote(\AppBundle\Entity\Note $notes)
    {
        if ($this->notes->contains($notes)) {
            $this->notes->removeElement($notes);
        }
        $notes->setCommunity(null);

        return $this;
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    public function preUpdate($community)
    {
        $community->setNotes($community->getNotes());
    }

    /**
     * Add events
     *
     * @param \AppBundle\Entity\Event $events
     * @return Community
     */
    public function addEvent(\AppBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \AppBundle\Entity\Event $events
     */
    public function removeEvent(\AppBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }
}
