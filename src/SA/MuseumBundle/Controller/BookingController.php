<?php

namespace SA\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookingController extends Controller
{
    public function indeAction()
    {
        $content = $this->get('templating')->render('SAMuseumBundle:B:index.html.twig');

        return new Response($content);
    }
}