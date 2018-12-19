<?php

namespace SA\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

Class Afternoon extends Constraint
{
    public $message = "il n'est plus possible de reserver un billet journée aujourdh'ui";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
