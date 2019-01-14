<?php

namespace Tests\SA\MuseumBundle\Services;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use SA\MuseumBundle\Entity\Booking;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Services\BookingManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingManagerTest extends TestCase
{

    public function testRateIfAgeIsUnder4()
    {
        $argMock = $this->createMock(EntityManagerInterface::class);
        $myClass = new BookingManager($argMock);
        $result  = $myClass->getMyRate('3');

        $this->assertSame(0, $result);

    }

    public function testRateIfAgeIsOver60()
    {
        $argMock = $this->createMock(EntityManagerInterface::class);
        $myClass = new BookingManager($argMock);
        $result  = $myClass->getMyRate(67);

        $this->assertSame(1200, $result);

    }

    public function testRateIfAgeIsBetween12And60()
    {
        $argMock = $this->createMock(EntityManagerInterface::class);
        $myClass = new BookingManager($argMock);
        $result  = $myClass->getMyRate('34');

        $this->assertSame(1600, $result);

    }

    public function testFullMuseum()
    {
        $argMock = $this->createMock(EntityManagerInterface::class);
        $myClass = new BookingManager($argMock);
        $result  = $myClass->isFull('3');

        $this->assertSame(true, $result);

    }

    public function testAgeWhenBirthdayisExpected()
    {

        $argMock = $this->createMock(EntityManagerInterface::class);
        $myClass = new BookingManager($argMock);
        $ticket  = new Ticket();
        $d       = \DateTime::createFromFormat('Y-m-d', '1949-01-30');
        $ticket->setBirthdate($d);
        $ticket->getBirthdate();
        $result  = $myClass->getAge($ticket);

        $this->assertSame('69', $result);

    }

    public function testAgeWhenBirthdayIsPassed()
    {

        $argMock = $this->createMock(EntityManagerInterface::class);
        $myClass = new BookingManager($argMock);
        $ticket  = new Ticket();
        $d       = \DateTime::createFromFormat('Y-m-d', '1948-01-30');
        $ticket->setBirthdate($d);
        $ticket->getBirthdate();
        $result  = $myClass->getAge($ticket);

        $this->assertSame('70', $result);
    }
}