<?php

namespace SA\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SAMuseumBundle:Default:index.html.twig');
    }
}
