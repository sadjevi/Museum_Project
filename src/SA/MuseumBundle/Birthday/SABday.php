<?php


namespace SA\MuseumBundle\Birthday;


use DateTime;
use SA\MuseumBundle\Entity\Ticket;

class SABday
{
    public function isbehind($birthdate)
    {
        $x = $birthdate;

        $y = $x->format('Y-m-d');
        $z = new DateTime($y);
        $monthin = $x->format('m');
        $dayin = $x->format('d');

        $now = new DateTime();
        $interval = $z->diff($now);
        $age = $interval->format('%Y');
        $monthout = $interval->format('%m');
        $dayout = $interval->format('%d');


        if( $monthout < $monthin && $dayin < $dayout)
        {
            $age = $age - 1;

        }


        return $age;
    }
}