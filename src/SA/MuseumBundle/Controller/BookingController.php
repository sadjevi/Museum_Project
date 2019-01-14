<?php


namespace SA\MuseumBundle\Controller;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use mysql_xdevapi\Session;
use SA\MuseumBundle\Entity\Booking;
use SA\MuseumBundle\Price\SACharge;
use SA\MuseumBundle\Rate\SARate;
use SA\MuseumBundle\Repository\TicketRepository;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Form\BookingType;
use SA\MuseumBundle\Form\TicketType;
use SA\MuseumBundle\SAMuseumBundle;
use SA\MuseumBundle\Services\BookingManager;
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
use vendor\project\StatusTest;


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

    public function addAction(Request $request, BookingManager $bookingManager)
    {
        $booking = new Booking();
        $form    = $this->createForm(BookingType::class, $booking);
        $em      = $this->getDoctrine()->getManager();

        // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            if(!$book = $bookingManager->isValid($request, $booking)){

                return $this->render('SAMuseumBundle:Booking:add.html.twig', array('form' => $form->createView()));
            }
            $em->persist($book);
            $em->flush();

            $request->getSession()->getFlashbag()->add('success', 'Reservation bien enregistrée.');

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
        $img     = $message->embed(\Swift_Image::fromPath('bundles/samuseum/images/téléchargement.jpeg'));
        $message
            ->setFrom('devmail@louvremuseum.com')
            ->setTo('sadjevi@me.com')
            ->setSubject('Votre reservation au Musée du Louvre')
            ->setBody($this->renderView('Email/mail.html.twig',
                array(
                    'booking'        => $booking,
                    'listTickets'    => $listTickets,
                    'img' => $img)),'text/html');

        $this->get('mailer')->send($message);

        return $this->render('SAMuseumBundle:Order:confirm.html.twig', array(
            'booking'        => $booking,
            'listTickets'    => $listTickets,

        ));
    }

}