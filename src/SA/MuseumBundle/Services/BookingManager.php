<?php


namespace SA\MuseumBundle\Services;


use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;
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
    CONST limit = 3;

    public function __construct(EntityManagerInterface $entityManager = null)
    {
        $this->em = $entityManager;
    }

    public function isValid(request $request, booking $booking)
    {
        $tickets  = $booking->getTickets();
        $total    = 0;

        foreach ($tickets as $ticket)
        {
            $em         = $this->em;
            $bookedday  = $ticket->getBookedday();
            $dayBooked  = $bookedday->format('d/m/Y');
            $myTickets  = $em->getRepository('SAMuseumBundle:Ticket')->findby(array('bookedday' => $bookedday));
            $ticketsNbr = count($myTickets);

            if ($this->isFull($ticketsNbr))
            {
                 $request->getSession()->getFlashbag()->add(
                     'warning',
                     'Musée complet ! Pour votre confort les visites sont limitées à 1000 visiteurs /jour...
                     le musée affichant complet le ' . $dayBooked .' merci de bien vouloir selectionner une
                     autre date ');
                // return null;
                return null;

            }

            $myAge  = $this->getAge($ticket);
            $myRate = $this->getMyRate($myAge);
            $ticket->setRate($myRate);
            $total  = $total + $myRate;
            $ticket->setBooking($booking);
        }
        $booking->setRate($total);
        $em = $this->em;
        $em->persist($booking);
        $em->flush();

        return $booking;



    }

    public function isFull($ticketsNbr)
    {

        return $ticketsNbr >= SELF::limit;
    }

    public function getAge(ticket $ticket)
    {
        $birthdate = $ticket->getBirthdate();
        $x         = $birthdate;
        $y         = $x->format('Y-m-d');
        $z         = new DateTime($y);
        $monthin   = $x->format('m');
        $dayin     = $x->format('d');
        $now       = new DateTime();
        $interval  = $z->diff($now);
        $age       = $interval->format('%Y');
        $monthout  = $interval->format('%m');
        $dayout    = $interval->format('%d');


        if( $monthout < $monthin && $dayin < $dayout)
        {
            $myAge = $age - 1;
        }
        else
        {
            $myAge = $age;
        }

        return $myAge;
    }

    public function getMyRate($myAge)
    {
        $a = $myAge;
        $ticket= new Ticket();

        if ($a < 12 && $a >= 4)
        {
            $ticket->setRate(800);
        }
        elseif ($a >= 12 && $a < 60)
        {
            $ticket->setRate(1600);
        }
        elseif ($a >= 60)
        {
            $ticket->setRate(1200);
        }
        elseif ($a < 4)
        {
            $ticket->setRate(0);
        }

        $myRate = $ticket->getRate();

        return $myRate;
    }


}
