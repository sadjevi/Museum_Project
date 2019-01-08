<?php

namespace SA\MuseumBundle\Controller;


use SA\MuseumBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use SA\MuseumBundle\SAMuseumBundle;




class OrderController extends Controller
{
    public function prepareAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('SAMuseumBundle:Booking')->find($id);
        return $this->render('SAMuseumBundle:order:prepare.html.twig',
            array(   'id' =>$booking->getId(),
                'booking' => $booking)
        );
    }

    public function checkoutAction($id)
    {
        $em      = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('SAMuseumBundle:Booking')->find($id);
        $listTickets = $em->getRepository('SAMuseumBundle:Ticket')->findBy(array('booking' => $booking));
        $rate = $booking->getRate();
        \Stripe\Stripe::setApiKey("sk_test_9QKwAblo8Jv30RTOoUTqbOLd");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $rate  , // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Reservation - Louvre_Munseum"
            ));
            $this->addFlash('info', "success","Bravo ça marche !");
            return $this->redirectToRoute("museum_mailsend", array('id' => $booking->getId()));

        } catch(\Stripe\Error\Card $e)

            {

                $this->addFlash('info', "error","Snif ça marche pas :(");
                return $this->redirectToRoute("museum_tickets_order");
                // The card has been declined
            }
    }

    public function confirmAction($id)
    {
        $em      = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('SAMuseumBundle:Booking')->find($id);
        $listTickets = $em->getRepository('SAMuseumBundle:Ticket')->findBy(array('booking' => $booking));
        return $this->render('SAMuseumBundle:order:confirm.html.twig',
            array('id' => $id,
                'booking' => $booking,
                'listTickets' => $listTickets));
    }

}