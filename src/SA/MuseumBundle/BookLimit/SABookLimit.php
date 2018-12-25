<?php


namespace SA\MuseumBundle\BookLimit;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
            ->setParameter('bookedday', $bookedday)
            ->select('count(t.bookedday)')
            ->from(Ticket::class,'t');
        try {
            $value = $qb
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e)
        {
            $e->getMessage();
        }

        return $value > 2;


    }
}