<?php


namespace SA\MuseumBundle\Controller;

use DateInterval;
use DateTime;
use mysql_xdevapi\Session;
use SA\MuseumBundle\Entity\Booking;
use SA\MuseumBundle\Price\SACharge;
use SA\MuseumBundle\Rate\SARate;
use SA\MuseumBundle\Repository\TicketRepository;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Form\BookingType;
use SA\MuseumBundle\Form\TicketType;
use SA\MuseumBundle\SAMuseumBundle;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use SendGrid;
use SA\MuseumBundle\Birthday;

class BookingController extends Controller
{
    public function viewAction($id)
    {
        // Ici, on récupérera la resa  correspondante à l'id $id

        $em          = $this->getDoctrine()->getManager();
        $booking     = $em->getRepository('SAMuseumBundle:Booking')->find($id);
        if (null === $booking)
        {
            throw new NotFoundHttpException("La commande d'id ".$id." n'existe pas.");
        }
        $listTickets = $em->getRepository('SAMuseumBundle:Ticket')->findBy(array('booking' => $booking));

        return $this->render('SAMuseumBundle:Booking:view.html.twig', array(
            'booking'        => $booking,
            'listTickets'    => $listTickets
        ));
    }

    public function addAction(Request $request)
    {
        $booking = new Booking();
        $form    = $this->createForm(BookingType::class, $booking);

        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {

            $em      = $this->getDoctrine()->getManager();
            $tickets = $booking->getTickets();
            $total   = 0;

            foreach ($tickets as $ticket)
            {

                $birthdate = $ticket->getBirthdate();
                $bookedday = $ticket->getBookedday();
                $myTickets = $em->getRepository('SAMuseumBundle:Ticket')->findby(array(
                    'bookedday' => $bookedday
                ));

                $limit     = $this->container->get('sa_museum.limit');

                if ($limit->isFull($myTickets))
                {
                    throw new Exception('il est impossible de reserver à la date selectionnée');
                }

                $q         = new Birthday\SABday();
                $age       = $q->isbehind($birthdate);

                $SARate    = new SACharge();
                $s         = $SARate->getPrice($age);

                $ticket->setRate($s);
                $total     = $total + $s;
                $ticket->setBooking($booking);
            }

           $booking->setRate($total);
           $em->persist($booking);
           $em->flush();



            $request->getSession()->getFlashbag()->add('notice', 'Reservation bien enregistrée.');
           // $this->mailAction($id);

            return $this->redirectToRoute('sa_museum_view', array('id' => $booking->getId()));
        }

         return $this->render('SAMuseumBundle:Booking:add.html.twig', array('form' => $form->createView()));
    }

    public function mailAction($id)
    {
        $em           = $this->getDoctrine()->getManager();
        $booking      = $em->getRepository('SAMuseumBundle:Booking')->find($id);
        $listTickets  = $em->getRepository('SAMuseumBundle:Ticket')->findBy(array('booking' => $booking));
        $message      = (new \Swift_Message('Confirmation de reservation'));
        $message
            ->setFrom('devmail@louvremuseum.com')
            ->setTo('sadjevi@me.com')
            ->setSubject('Subject')
            ->setBody($this->renderView('Email/mail.html.twig',
                array(
                    'booking'        => $booking,
                    'listTickets'    => $listTickets)),'text/html');

        $this->get('mailer')->send($message);

        return $this->render('SAMuseumBundle:Order:confirm.html.twig', array(
            'booking'        => $booking,
            'listTickets'    => $listTickets,

        ));
    }


    public function testAction()
    {


        $bookedday = new DateTime('2018-12-23');
        $em = $this->getDoctrine()->getManager();
        $myTickets = $em->getRepository('SAMuseumBundle:Ticket')->findby(array(
            'bookedday' => $bookedday
        ));
        $nbr = count($myTickets);
        $limit = $this->container->get('sa_museum.limit');

        if ($limit->isFull($myTickets))
        {
            throw new Exception('il est impossible de reserver à la date selectionnée');

        }



        return $this->render('SAMuseumBundle:Ticket:test.html.twig',array(
            'myTickets' => $myTickets,
            'nbr' => $nbr

        ));
    }

    /*public function editAction($id, Request $request)
    {
        // Ici, on récupérera la resa correspondante à $id

        // Même mécanisme que pour l'ajout
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'reservation bien modifiée.');

            return $this->redirectToRoute('sa_platform_view', array('id' => 5));
        }

        return $this->render('OCPlatformBundle:Advert:edit.html.twig');
    }*/

}