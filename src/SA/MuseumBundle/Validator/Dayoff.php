<?php

namespace SA\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

Class Dayoff extends Constraint
{
    public $message = "il est impossible d 'effectuer une reservation le jour selectionné,merci de selectionner
    un autre jour.";
}