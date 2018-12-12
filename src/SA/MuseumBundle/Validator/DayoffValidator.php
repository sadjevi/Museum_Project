<?php

namespace SA\MuseumBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;

class DayoffValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if(date_format($value,'l') == 'Tuesday')
        {
            $this->context->addViolation($constraint->message);

        }

    }

}



