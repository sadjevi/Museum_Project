<?php

namespace SA\MuseumBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SA\MuseumBundle\Entity\Ticket;

class DayoffValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $today = date('Y-m-d H:i:s');
        if(date_format($value,'l') == 'Tuesday'
        || date_format($value,'l') == 'Sunday'
        || date_format($value,'d/m') == '01/05'
        || date_format($value,'d/m') == '01/11'
        || date_format($value,'d/m') == '25/12'
        || $value = $today && date_format($value,'H') < '14')

        {
            $this->context->addViolation($constraint->message);
        }
    }
}



