<?php

namespace SA\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

Class Afternoon extends Constraint
{
    public $message = " Désolé il n'est plus possible de réserver un billet demi-journée aujourd'hui";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
