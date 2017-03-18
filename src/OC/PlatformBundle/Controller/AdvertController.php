<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Image;
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
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                'date' => new \DateTime()
            ),
            array(
                'title' => 'Webdesigner',
                'idAdvert' => '9',
                'author' => 'John Doe',
                'content' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem',
                'date' => new \DateTime()
            ),
            array(
                'title' => 'Opticien',
                'idAdvert' => '10',
                'author' => 'Opticol Center',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                'date' => new \DateTime()
            ),
            array(
                'title' => 'Agent EDF',
                'idAdvert' => '11',
                'author' => 'EDF centre RH',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                'date' => new \DateTime()
            ),
            array(
                'title' => 'Postier',
                'idAdvert' => '12',
                'author' => 'La Poste',
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
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
        $em = $this->getDoctrine()->getManager();

        //On récupère l'id de l'annonce en cours
        $advert = $em
            ->getRepository("OCPlatformBundle:Advert")
            ->find($idAdvert);

        if(null == $advert){
            throw new NotFoundHttpException("L'annonce d'id ".$idAdvert." n'existe pas");
        }

        //On récupère la liste des candidatures pour cette annonce
        $listApplication = $em
            ->getRepository("OCPlatformBundle:Application")
            ->findBy(array('advert' => $advert))
        ;

        //On récupère la liste des skills pouir cette annonce
        $listAdvertSkills = $em
            ->getRepository("OCPlatformBundle:AdvertSkill")
            ->findBy(array('advert' => $advert))
        ;

        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplication' => $listApplication,
            'listAdvertSkills' => $listAdvertSkills
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Creation de l'annonce
        $advert = new Advert();
        $advert->setTitle("Recherche développeur Symfony");
        $advert->setAuthor("John Doe");
        $advert->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam");

        //Creation de l'image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        // On lie l'image à l'annonce
        $advert->setImage($image);

        //Creation des candidatures
        $application = new Application();
        $application->setAuthor("Obry Clément");
        $application->setContent("Je postule pour cette annonce surper interessante");
        $application->setAdvert($advert);
        $application2 = new Application();
        $application2->setAuthor("Damien Holder");
        $application2->setContent("Je voudrais venir vous rejoindre");
        $application2->setAdvert($advert);

        $listSkill = $em->getRepository("OCPlatformBundle:Skill")->findAll();

        foreach ($listSkill as $skill){
            $advertSkill = new AdvertSkill();
            $advertSkill->setAdvert($advert);
            $advertSkill->setSkill($skill);
            $advertSkill->setLevel("Expert");

            $em->persist($advertSkill);
        }

        $em->persist($advert);
        $em->persist($application);
        $em->persist($application2);

        $em->flush();

        if($request->isMethod('POST')){
            $request->getSession()->getFlashBag()->add('info_ajout', 'Annonce bien enregistrée');

            return $this->redirectToRoute('oc_platform_view',array('idAdvert' => $advert->getId()));
        }

        return $this->render('OCPlatformBundle:Advert:add.html.twig', array('advert'=>$advert));
    }

    /**
     * @param $idAdvert
     * @return Response
     */
    public function deleteAction($idAdvert)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository("OCPlatformBundle:Advert")->find($idAdvert);

        if($advert == null){
            throw new NotFoundHttpException("L'annonce ".$idAdvert." n\'existe pas");
        }

        foreach ($advert->getCategories() as $category){
            $advert->removeCategory($category);
        }

        $em->flush();

        return $this->render('OCPlatformBundle:Advert:delete.html.twig', array('advert' => $advert));
    }

    /**
     * @param $idAdvert
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction($idAdvert, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository("OCPlatformBundle:Advert")->find($idAdvert);

        if($advert == null){
            throw new NotFoundHttpException("L'annonce ".$idAdvert." n\'existe pas");
        }

        $listCategories = $em->getRepository("OCPlatformBundle:Category")->findAll();

        foreach ($listCategories as $category){
            $advert->addCategory($category);
        }

        $em->flush();

        if($request->isMethod('POST')){
            //traitement BDD
            $request->getSession()->getFlashBag()->add('info_edit','Annonce correctement modifiée');

            return $this->redirectToRoute('oc_platform_view',array('idAdvert' => 9));
        }



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
            array('idAdvert' => 9, 'title' => 'Webdesigner')
        );

        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array('listAdverts'=>$listAdverts));
    }
}
