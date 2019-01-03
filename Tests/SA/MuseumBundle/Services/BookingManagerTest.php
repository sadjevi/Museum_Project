<?php

namespace Tests\SA\MuseumBundle\Services;

use PHPUnit\Framework\TestCase;
use SA\MuseumBundle\Entity\Booking;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Services\BookingManager;
use Doctrine\ORM\EntityManager;

class BookingManagerTest extends TestCase
{
    public function testMuseumIsFull()
    {
        $booking = new Booking();
        $booking->setRate('5400');
        $booking->setTicketsnbr('3');
        $booking->setMail('tartenpion@sfr.com');


        $ticket1 = new Ticket();

        $ticket1->setName('one');
        $ticket1->setForename('fone');
        $ticket1->setBirthdate('01/12/1978');
        $ticket1->setCountry('france');
        $ticket1->setRate('1800');
        $ticket1->setSlot(false);
        $ticket1->setSpecialrate(false);

        $ticket2 = new Ticket();
        $ticket2->setName('one');
        $ticket2->setForename('fone');
        $ticket2->setBirthdate('01/12/1978');
        $ticket2->setCountry('france');
        $ticket2->setRate('1800');
        $ticket2->setSlot(false);
        $ticket2->setSpecialrate(false);

        $ticket3 = new Ticket();
        $ticket3->setName('one');
        $ticket3->setForename('fone');
        $ticket3->setBirthdate('01/12/1978');
        $ticket3->setCountry('france');
        $ticket3->setRate('1800');
        $ticket3->setSlot(false);
        $ticket3->setSpecialrate(false);

        $ticket1->setBooking($booking);
        $ticket2->setBooking($booking);
        $ticket3->setBooking($booking);




    }
}