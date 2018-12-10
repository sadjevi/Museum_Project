<?php

namespace SA\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="SA\MuseumBundle\Repository\BookingRepository")
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
     */
    private $mail;


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
}

