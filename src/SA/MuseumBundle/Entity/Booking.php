<?php

namespace SA\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="SA\MuseumBundle\Repository\BookingRepository")
 *
 */
class Booking
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
     * @var \DateTime
     *
     * @ORM\Column(name="bookedat", type="datetime")
     */
    private $bookedat;

    /**
     * @var int
     *
     * @ORM\Column(name="ticketsnbr", type="integer")
     * @Assert\Type(type="integer")
     */
    private $ticketsnbr;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     */
    private $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email
     */
    private $mail;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="SA\MuseumBundle\Entity\Ticket", mappedBy = "booking",cascade={"persist"})
     * @Assert\Valid
     */
    protected $tickets;


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
     * Set bookedat
     *
     * @param \DateTime $bookedat
     *
     * @return Booking
     */
    public function setBookedat($bookedat)
    {
        $this->bookedat = $bookedat;

        return $this;
    }

    /**
     * Get bookedat
     *
     * @return \DateTime
     */
    public function getBookedat()
    {
        return $this->bookedat;
    }

    /**
     * Set ticketsnbr
     *
     * @param integer $ticketsnbr
     *
     * @return Booking
     */
    public function setTicketsnbr($ticketsnbr)
    {
        $this->ticketsnbr = $ticketsnbr;

        return $this;
    }

    /**
     * Get ticketsnbr
     *
     * @return int
     */
    public function getTicketsnbr()
    {
        return $this->ticketsnbr;
    }

    /**
     * Set rate
     *
     * @param float $rate
     *
     * @return Booking
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
     * Set mail
     *
     * @param string $mail
     *
     * @return Booking
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bookedat = new \Datetime();
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ticket
     *
     * @param \Project\MuseumBundle\Entity\Ticket $ticket
     *
     * @return Booking
     */
    public function addTicket(\SA\MuseumBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setBooking($this);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \Project\MuseumBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\SA\MuseumBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}

