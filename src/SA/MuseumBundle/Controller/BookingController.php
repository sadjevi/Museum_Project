<?php


namespace SA\MuseumBundle\Controller;

use DateTime;
use SA\MuseumBundle\Entity\Booking;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Form\BookingType;
use SA\MuseumBundle\Form\TicketType;
use SA\MuseumBundle\SAMuseumBundle;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use SendGrid;

class BookingController extends Controller
{
    public function viewAction($id)
    {
        // Ici, on récupérera la resa  correspondante à l'id $id

        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('SAMuseumBundle:Booking')->find($id);
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


        $form = $this->createForm(BookingType::class, $booking);

        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $tickets = $booking->getTickets();
            $total = 0;

            foreach ($tickets as $ticket)
            {
                /*if($ticket->getAge() < 12 && $ticket->getAge() >=4 )
                {
                    $ticket->setRate(800);
                }
                if($ticket->getAge() >=12 && $ticket->getAge() <60)
                {
                    $ticket->setRate(1600);
                }
                if($ticket->getAge()  >=60)
                {
                    $ticket->setRate(1200);
                }
                if($ticket->getAge()  <4 )
                {
                    $ticket->setRate(0);
                }*/
                $x = $ticket->getBirthdate();
                $y = $x->format('Y-m-d');
                $z = new DateTime($y);
                $now = new DateTime;
                $interval = $z->diff($now);
                $age = $interval->format('%Y');

                if($age <12 && $age >= 4)
                {
                    $ticket->setRate(800);
                }
                if($age >= 12 && $age < 60)
                {
                    $ticket->setRate(1600);
                }
                if($age >= 60 )
                {
                    $ticket->setRate(1200);
                }
                if($age < 4)
                {
                    $ticket->setRate(0);
                }
                 if($ticket->getSpecialrate() > 0)
                 {
                     $ticket->setRate(1000);
                 }



                $total = $total + $ticket->getRate();
                $ticket->setBooking($booking);
            }

           $booking->setRate($total);
           $em->persist($booking);

           $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Reservation bien enregistrée.');
           // $this->mailAction($id);

            return $this->redirectToRoute('sa_museum_view', array('id' => $booking->getId()));
        }

         return $this->render('SAMuseumBundle:Booking:add.html.twig', array('form' => $form->createView()));
    }

    public function mailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('SAMuseumBundle:Booking')->find($id);
        $listTickets = $em->getRepository('SAMuseumBundle:Ticket')->findBy(array('booking' => $booking));
        $message = (new \Swift_Message('Confirmation de reservation'));
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
            'listTickets'    => $listTickets
        ));
    }

    public function oneDayBooksAction($bookedday)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('SAMuseumBundle:Ticket');
        $listTickets = $repository->findBy(array('bookedday' => $bookedday));



        return $this->render('SAMuseumBundle:Ticket:view.html.twig', array(
            'listTickets'    => $listTickets
        ));
    }

   /* public function getAge($date)
    {
        $ticket = New Ticket;
        $startdate = $ticket->getBirthdate($date);
        $interval = $startdate->diff('New\DateTime()');
        $age = $interval$->format('%Y');

        return $age;

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