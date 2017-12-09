<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=255)
     */
    private $place;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * constructor for date and creators
     *
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->creators = new ArrayCollection();
    }

    /**
     * @var string
     * @ORM\Column(name="totalCapacity", type="string", length=10)
     */
    private $totalCapacity;

    /**
     * @var integer
     * @ORM\Column(name="reserved", type="integer", length=2)
     */
    private $reserved;

    /**
     * @var string
     * Many Event have One category
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="event")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;

    /**
     *
     * Many events has one creator
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $creators;

    /**
     * Many Event have Many User
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User", inversedBy="events")
     * @ORM\JoinTable(name="participation")
     */
    private $participants;

    /**
     * @var boolean
     * @ORM\Column(name="booking", type="boolean", options={"default":false})
     */
    private $booking;

    /**
     * One Event has One Adress
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Adress", inversedBy="event")
     * @ORM\JoinColumn(name="adress_id", referencedColumnName="id")
     */
    private $adress;

    /**
     * One Event has Many Commentary
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commentary", mappedBy="event")
     */
    private $commentary;

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
     * @return Event
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
     * Set place
     *
     * @param string $place
     *
     * @return Event
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Event
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return mixed
     */
    public function getCommentary()
    {
        return $this->commentary;
    }

    /**
     * @param mixed $commentary
     */
    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;
    }

    /**
     * Get creators
     * @return ArrayCollection();
     */
    public function getCreators()
    {
        return $this->creators;
    }

    /**
     * Add creators
     *
     * @param User $creators
     *
     * @return Event
     */
    public function addCreators(User $creators)
    {
        $this->creators[] = $creators;
        return $this;
    }

    /**
     * Remove creators
     * @param User $creators
     */
    public function removeCreators(User $creators)
    {
        $this->creators->removeElement($creators);
    }

    /**
     * @param mixed $creators
     */
    public function setCreator($creators)
    {
        $this->creators = $creators;
    }

    /**
     * @return mixed
     */
    public function gettotalCapacity()
    {
        return $this->totalCapacity;
    }

    /**
     * @param mixed $totalCapacity
     */
    public function settotalCapacity($totalCapacity)
    {
        $this->totalCapacity = $totalCapacity;
    }

    /**
     * @return mixed
     */
    public function getBooking()
    {
        return $this->booking;
    }

    /**
     * @param mixed $booking
     */
    public function setBooking($booking)
    {
        $this->booking = $booking;
    }

    /**
     * @return int
     */
    public function getReserved() : int
    {
        return $this->reserved;
    }

    /**
     * @param int $reserved
     */
    public function setReserved(int $reserved)
    {
        $this->reserved = $reserved;
    }

    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }
}
