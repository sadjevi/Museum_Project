<?php

namespace SA\MuseumBundle\Validator;


use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;

class AfternoonValidator extends ConstraintValidator
{
    public function validate($ticket, Constraint $constraint)
    {
        $slot = $ticket->getSlot();
        $visitDay = $ticket->getBookedday();
        $bookedDay = date_format($visitDay,'Y-m-d ');
        $now =  date('Y-m-d ');
        $nowH = date('H');

        if ($bookedDay == $now  && $nowH >= 13 && $slot == true )
        {
            $this->context->buildViolation($constraint->message)
                ->atPath('slot')
                ->addViolation();
        }
    }
}
