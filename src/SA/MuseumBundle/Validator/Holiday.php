<?php

namespace SA\MuseumBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */

Class Holiday extends Constraint
{
    public $message = "Le musée n'est malheureusement pas ouvert au public les jours fériés.Merci de votre comprehension.";


    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}