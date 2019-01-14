<?php

namespace SA\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

Class Dayoff extends Constraint
{
    public $message = "Le musée est malheureusement fermé le jour sélectionné ,merci de réserver
    un autre jour.";


    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}