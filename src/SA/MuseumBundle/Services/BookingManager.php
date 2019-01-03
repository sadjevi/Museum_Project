<?php


namespace SA\MuseumBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use DateTime;
use Doctrine\ORM\EntityManager;



class BookingManager
{

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function isValid(booking $booking)
    {
        $em = $this->em;
        $tickets = $booking->getTickets();
        $total = 0;

        foreach ($tickets as $ticket)
        {

            $birthdate = $ticket->getBirthdate();
            $bookedday = $ticket->getBookedday();
            $myTickets = $em->getRepository('SAMuseumBundle:Ticket')->findby(array('bookedday' => $bookedday));

            if (count($myTickets) >= 3)
            {
                throw new Exception('il est impossible de reserver à la date selectionnée');
            }

                $x = $birthdate;
                $y = $x->format('Y-m-d');
                $z = new DateTime($y);
                $monthin = $x->format('m');
                $dayin = $x->format('d');
                $now = new DateTime();
                $interval = $z->diff($now);
                $age = $interval->format('%Y');
                $monthout = $interval->format('%m');
                $dayout = $interval->format('%d');

                if ($monthout < $monthin && $dayin < $dayout)
                {
                    $birthday = $age - 1;
                }

                else
                {
                    $birthday = $age;
                }

                if ($birthday < 12 && $birthday >= 4)
                {
                    $ticket->setRate(800);
                }
                elseif ($birthday >= 12 && $birthday < 60)
                {
                    $ticket->setRate(1600);
                }
                elseif ($birthday >= 60)
                {
                    $ticket->setRate(1200);
                }
                elseif ($birthday < 4)
                {
                    $ticket->setRate(0);
                }

                $total = $total + $ticket->getRate();
                $ticket->setBooking($booking);
            }
            $booking->setRate($total);

            return $booking;
    }

    
}