<?php

namespace SA\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('SAMuseumBundle:Default:index.html.twig');
    }

    public function infosAction()
    {
        return $this->render('SAMuseumBundle:Default:infos.html.twig');

    }

    public function legalNoticeAction()
    {
        return $this->render('SAMuseumBundle:Default:legalnotice.html.twig');
    }
}