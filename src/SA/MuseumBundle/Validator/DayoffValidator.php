<?php

namespace SA\MuseumBundle\Validator;


use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;

class DayoffValidator extends ConstraintValidator
{
    public function validate($ticket, Constraint $constraint)
    {

        $bookedday = $ticket->getBookedday();
        $today = New \DateTime();
        $now = date('Y-m-d');

        if(
            date_format($bookedday,'l') == 'Tuesday' ||
            date_format($bookedday,'l') == 'Sunday'  ||
            date_format($bookedday,'d/m') == '01/05' ||
            date_format($bookedday,'d/m') == '01/11' ||
            date_format($bookedday,'d/m') == '25/12' 
        )
        {
            $this->context->buildViolation($constraint->message)
             ->atPath('bookedday')
             ->addViolation();
        }


    //$bookedday = date('Y-m-d H:i:s');



    }
}



