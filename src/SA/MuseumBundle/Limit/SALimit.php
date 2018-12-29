<?php


namespace SA\MuseumBundle\Limit;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use SA\MuseumBundle\Entity\Ticket;
use SA\MuseumBundle\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class SALimit
{

    public function isFull($myTickets)
    {

        return count($myTickets) >= 3;

    }

}