<?php


namespace SA\MuseumBundle\BookLimit;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class SABookLimit extends EntityRepository
{
public function isFull($bookedday)
    {
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.bookedday = :bookedday')
            ->setParameter('bookedday', $bookedday);
            ->select('count(t.bookedday)')
            ->from(Ticket::class,'t');
        $value = $qb
            ->getQuery()
            ->getResult()
                 try {}catch(\Stripe\Error\Card $e);
            );

        return $value;

        return $nbr >= 1000;
    }
}