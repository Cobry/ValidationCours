<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\OCPlatformBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        if ($page<1){
            throw new NotFoundHttpException('Page n°'.$page.' inexistante');
        }
        return $this->render('OCPlatformBundle:Advert:index.html.twig', array('listAdverts' => array()));
    }

    public function viewAction($idAdvert)
    {
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array('idAdvert' => $idAdvert));
    }

    public function addAction(Request $request)
    {
        if($request->isMethod('POST')){
            //Traitement BDD
            $request->getSession()->getFlashBag()->add('info_ajout', 'Annonce bien enregistrée');

            return $this->redirectToRoute('oc_platform_view',array('idAdvert' => 8));
        }

        return $this->render('OCPlatformBundle:Advert:add.html.twig');

    }

    public function deleteAction($idAdvert)
    {
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }

    public function editAction($idAdvert, Request $request)
    {
        if($request->isMethod('POST')){
            //traitement BDD
            $request->getSession()->getFlashBag()->add('info_edit','Annonce correctement modifiée');

            return $this->redirectToRoute('oc_platform_view',array('idAdvert' => 8));
        }

        return $this->render('OCPlatformBundle:Advert:edit.html.twig');
    }

    public function menuAction($limit)
    {
        $listAdverts= array(
            array('idAdvert' => 2, 'title' => 'Développeur symfony'),
            array('idAdvert' => 5, 'title' => 'Webmaster'),
            array('idAdvert' => 9, 'title' => 'Websigner')
        );

        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array('listAdverts'=>$listAdverts));
    }
}
