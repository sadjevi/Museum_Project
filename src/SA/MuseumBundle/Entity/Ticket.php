<?php

namespace SA\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use SA\MuseumBundle\Validator\Dayoff;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="SA\MuseumBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\ManyToOne(targetEntity="SA\MuseumBundle\Entity\Booking", inversedBy = "tickets" )
     * @ORM\JoinColumn(nullable=TRUE)
     */
    protected $booking;

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
     * @Assert\NotBlank
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="forename", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $forename;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     * @Assert\NotBlank()
     */
    private $age;

    /**
     * @var bool
     *
     * @ORM\Column(name="slot", type="boolean")
     */
    private $slot = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookedday", type="datetime")
     *@Assert\Range(
     *     min = "now-1 hour",
     *     max = "last day of December next year"
     *     )
     * @Dayoff()
     */
    private $bookedday;


    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     *
     */
    private $rate;


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
     * @return Ticket
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
     * Set forename
     *
     * @param string $forename
     *
     * @return Ticket
     */
    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    /**
     * Get forename
     *
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Ticket
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set slot
     *
     * @param boolean $slot
     *
     * @return Ticket
     */
    public function setSlot($slot)
    {
        $this->slot = $slot;

        return $this;
    }

    /**
     * Get slot
     *
     * @return bool
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * Set bookedday
     *
     * @param \DateTime $bookedday
     *
     * @return Ticket
     */
    public function setBookedday($bookedday)
    {
        $this->bookedday = $bookedday;

        return $this;
    }

    /**
     * Get bookedday
     *
     * @return \DateTime
     */
    public function getBookedday()
    {
        return $this->bookedday;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return Ticket
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set booking
     *
     * @param \Project\MuseumBundle\Entity\Booking $booking
     *
     * @return Ticket
     */
    public function setBooking(\SA\MuseumBundle\Entity\Booking $booking = null)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \Project\MuseumBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
