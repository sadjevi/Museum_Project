<?php

namespace SA\MuseumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction($page)
    {
        // On ne sait pas combien de pages il y a
        // Mais on sait qu'une page doit être supérieure ou égale à 1
        if ($page < 1) {
            // On déclenche une exception NotFoundHttpException, cela va afficher
            // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }

      // pour l'instant, on ne fait qu'appeler le template
        return $this->render('SAMuseumBundle:Default:index.html.twig');
    }

    public function infosAction()
    {
        return $this->render('SAMuseumBundle:Default:infos.html.twig');

    }
}