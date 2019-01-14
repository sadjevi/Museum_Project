<?php

namespace SA\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use SA\MuseumBundle\Validator\Dayoff;
use SA\MuseumBundle\Validator\Afternoon;
use SA\MuseumBundle\Validator\Holiday;


/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="SA\MuseumBundle\Repository\TicketRepository")
 * @Dayoff()
 * @Afternoon()
 * @Holiday()
 *
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
     * @Assert\NotBlank(message = "Ce champ doit être rempli.")
     * @Assert\Length(
     *     min =2,
     *     max = 15,
     *     minMessage = "Le nom doit contenir un minimum de {{ limit }} caractères",
     *     maxMessage = "Le nom ne peut contenir plus de {{ limit }} caractères"
     *     )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="forename", type="string", length=255)
     * @Assert\NotBlank(message = "Ce champ doit être rempli.")
     * @Assert\Length(
     *     min = 2,
     *     max = 15,
     *     minMessage = "Le prénom doit contenir un minimum de {{ limit }} caractères",
     *     maxMessage = "Le prénom ne peut contenir plus de {{ limit }} caractères"
     *     )
     */
    private $forename;

    /**
     *  @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="datetime")
     * @Assert\NotBlank(message = "Ce champ doit être rempli.")
     * @Assert\Date()
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     * @Assert\NotBlank(message = "Ce champ doit être rempli.")
     * @Assert\Country(
     *     message = "{{ value }} n'est pas un pays valide"
     *     )
     */
    private $country;

    /**
     * @var bool
     *
     * @ORM\Column(name="slot", type="boolean")
     * @Assert\Type("boolean")
     *
     */
    private $slot ;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookedday", type="datetime")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = "now - 1 day",
     *      max = "first day of December next year",
     *      minMessage = "vous ne pouvez rentrer une date anterieur à aujourdh'ui,merci de saisir une autre date",
     *      maxMessage = "il est impossible de reserver une date posterieure au  {{ limit }}.Merci de bien vouloir selectionner une autre date"
     * )
     *
     *
     */
    private $bookedday;

    /**
     * @var bool
     *
     * @ORM\Column(name="specialrate", type="boolean")
     * @Assert\Type("boolean")
     */
    private $specialrate = true;


    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float")
     * @Assert\Type(type="float")
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

    /**
     * Set country.
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set specialrate.
     *
     * @param bool $specialrate
     *
     * @return Ticket
     */
    public function setSpecialrate($specialrate)
    {
        $this->specialrate = $specialrate;

        return $this;
    }

    /**
     * Get specialrate.
     *
     * @return bool
     */
    public function getSpecialrate()
    {
        return $this->specialrate;
    }

    /**
     * Set birthdate.
     *
     * @param \DateTime $birthdate
     *
     * @return Ticket
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate.
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
}

