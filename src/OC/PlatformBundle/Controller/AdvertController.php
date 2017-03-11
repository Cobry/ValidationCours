<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\OCPlatformBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends Controller
{
    public function indexAction()
    {
        $content = $this->get('templating')->render('OCPlatformBundle:Advert:index.html.twig', array('nom' => 'Obry'));
        return new Response($content);
    }

    public function viewAction($idAdvert)
    {
        return new Response("Affichage de l'annonce de l'id : ".$idAdvert);
    }

}
