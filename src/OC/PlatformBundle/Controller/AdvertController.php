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
    /**
     * @param $page
     * @return Response
     */
    public function indexAction($page)
    {
        if ($page<1){
            throw new NotFoundHttpException('Page n°'.$page.' inexistante');
        }

        //La liste d'annonce en dur
        $listAdverts = array(
            array(
                'title' => 'Développeur en symfony',
                'idAdvert' => '2',
                'author' => 'Obyr Clément',
                'content' => 'Nous recherchons un développeur symfony chez Entreprise',
                'date' => new \DateTime()
            ),
            array(
                'title' => 'Webmaster',
                'idAdvert' => '5',
                'author' => 'Jean dupont',
                'content' => 'Loremp azioepiazeazi pdz azjdizadjazid azdnaziodnjazidazd',
                'date' => new \DateTime()
            ),
            array(
                'title' => 'Webdesigner',
                'idAdvert' => '9',
                'author' => 'Delire me',
                'content' => 'Oidzo djzd ioere dzdpo smsoz aoidziu dzaduh',
                'date' => new \DateTime()
            )
        );

        return $this->render('OCPlatformBundle:Advert:index.html.twig', array('listAdverts' => $listAdverts));
    }

    /**
     * @param $idAdvert
     * @return Response
     */
    public function viewAction($idAdvert)
    {
        $advert = array(
            'title' => 'Webdesigner',
            'idAdvert' => $idAdvert,
            'author' => 'Delire me',
            'content' => 'Oidzo djzd ioere dzdpo smsoz aoidziu dzaduh',
            'date' => new \DateTime()
        );
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array('advert' => $advert));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        if($request->isMethod('POST')){

            $antispam = $this->container->get('oc_platform.antispam');

            $text = '...';

            if($antispam->isSpam($text)){
                throw new \Exception('Votre message est un spam');
            }

            //Traitement BDD
            $request->getSession()->getFlashBag()->add('info_ajout', 'Annonce bien enregistrée');

            return $this->redirectToRoute('oc_platform_view',array('idAdvert' => 8));
        }

        return $this->render('OCPlatformBundle:Advert:add.html.twig');

    }

    /**
     * @param $idAdvert
     * @return Response
     */
    public function deleteAction($idAdvert)
    {
        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }

    /**
     * @param $idAdvert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction($idAdvert, Request $request)
    {
        if($request->isMethod('POST')){
            //traitement BDD
            $request->getSession()->getFlashBag()->add('info_edit','Annonce correctement modifiée');

            return $this->redirectToRoute('oc_platform_view',array('idAdvert' => 8));
        }

        $advert = array(
            'title' => 'Webdesigner',
            'idAdvert' => $idAdvert,
            'author' => 'Delire me',
            'content' => 'Oidzo djzd ioere dzdpo smsoz aoidziu dzaduh',
            'date' => new \DateTime()
        );

        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array('advert' => $advert));
    }

    /**
     * @param $limit
     * @return Response
     */
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
