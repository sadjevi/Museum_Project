<?php


namespace SA\MuseumBundle\Price;


use SA\MuseumBundle\Entity\Ticket;

class SACharge
{
    public function getPrice($age)
    {
        $ticket = new Ticket();

        if($age <12 && $age >= 4)
        {
             $ticket->setRate(800);
        }
        elseif($age >= 12 && $age < 60)
        {
             $ticket->setRate(1600);
        }
        elseif($age >= 60 )
        {
             $ticket->setRate(1200);
        }
        elseif($age < 4)
        {
             $ticket->setRate(0);
        }

        $rate = $ticket->getRate();

        return $rate;
    }
}