<?php


namespace SA\MuseumBundle\Controller;

use SA\MuseumBundle\Entity\Booking;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Form\BookingType;
use SA\MuseumBundle\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                $ticket->setRate(32);

                $total = $total + $ticket->getRate();
                $ticket->setBooking($booking);
            }

           $booking->setRate($total);
           $em->persist($booking);

           $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Reservation bien enregistrée.');

            return $this->redirectToRoute('sa_museum_view', array('id' => $booking->getId()));
        }

         return $this->render('SAMuseumBundle:Booking:add.html.twig', array('form' => $form->createView()));
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