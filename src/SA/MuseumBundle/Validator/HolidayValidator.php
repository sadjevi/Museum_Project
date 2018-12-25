<?php

namespace SA\MuseumBundle\Validator;


use DateInterval;
use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;

class HolidayValidator extends ConstraintValidator
{
    public function validate($ticket, Constraint $constraint)
    {

        $bookedday = $ticket->getBookedday();
        $year = date_format($bookedday,'Y');
        $easterDay = date('Y-m-d', easter_date($year));

        $r = date('Y-m-d', strtotime($easterDay.' + 1 DAY'));
        $x = date('Y-m-d', strtotime($easterDay.' + 2 DAY'));
        $y = date('Y-m-d', strtotime($easterDay.' + 40 DAY'));
        $z = date('Y-m-d', strtotime($easterDay.' + 51 DAY'));

        if(
            date_format($bookedday,'Y-m-d') == $easterDay ||
            date_format($bookedday,'Y-m-d') == $r ||
            date_format($bookedday,'Y-m-d') == $x ||
            date_format($bookedday,'Y-m-d') == $y ||
            date_format($bookedday,'Y-m-d') == $z
        )
        {
            $this->context->buildViolation($constraint->message)
                ->atPath('bookedday')
                ->addViolation();
        }

    }
}