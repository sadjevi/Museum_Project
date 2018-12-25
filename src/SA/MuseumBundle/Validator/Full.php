<?php

namespace SA\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

Class Full extends Constraint
{

    public $message = "les reservations sont fermées pour la date selectionnée.";


    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}