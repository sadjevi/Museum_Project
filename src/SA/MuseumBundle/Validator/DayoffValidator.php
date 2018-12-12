<?php

namespace SA\MuseumBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;

class DayoffValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(date_format($value,'l') == 'Tuesday'
        || date_format($value,'l') == 'Sunday'
        || date_format($value,'d/m') == '01/05'
        || date_format($value,'d/m') == '01/11'
        || date_format($value,'d/m') == '25/12')

        {
            $this->context->addViolation($constraint->message);
        }
    }
}



