<?php

namespace SA\MuseumBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;


class FullValidator extends ConstraintValidator
{
    public function validate($ticket, Constraint $constraint)
    {
        $bookLimit = $this->container->get('sa_museum_booklimit');
        $bookedDay = $ticket->getBookedday();


        if ($bookLimit->isFull($bookedDay))
        {
            $this->context->buildViolation($constraint->message)
                ->atPath('bookedday')
                ->addViolation();
        }
    }
}









