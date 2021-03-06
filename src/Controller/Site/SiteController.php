<?php

namespace App\Controller\Site;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Security\UserType;
use App\Entity\Security\User;
use App\Entity\Security\Commenti;
use App\Form\Security\CommentiType;
use App\Entity\Security\Likecomment;
use App\Form\Security\LikecommentType;
use App\Form\Admin\ArticolicategoriaType;
use App\Entity\Admin\Articolicategoria;
use App\Entity\Admin\Pubblicita;
use App\Form\Admin\ArticoliType;
use App\Entity\Admin\Articoli;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;

class SiteController extends Controller
{
  const DEFAULT_LIMIT = 2;
  /**
   * @Route("/home", name="home")
   */
  public function homeAction()
  {
   $entityManager = $this->getDoctrine()->getManager();
   $home = $entityManager->getRepository(Articoli::class)->findFirst();
   $articoli = $entityManager->getRepository(Articoli::class)->findByArticolo(self::DEFAULT_LIMIT);
   $categoria = $entityManager->getRepository(Articolicategoria::class)->findCategoria();
   $pubblicita = $entityManager->getRepository(Pubblicita::class)->findAll();
   return $this->render('site/index.html.twig',array(
     'home' => $home,
     'categoria' => $categoria,
     'articoli' => $articoli,
     'pubblicita' => $pubblicita
   ));
 }

 /**
 * @Route("/categoria/{id}", name="categoriasite")
 */
 public function categoriasiteAction(Request $request,$id)
 {
   $entityManager = $this->getDoctrine()->getManager();
   $categoria = $entityManager->getRepository(Articolicategoria::class)->find(array('id' => $id));
   $articoli = $entityManager->getRepository(Articoli::class)->findByArticolo(self::DEFAULT_LIMIT);
   $pubblicita = $entityManager->getRepository(Pubblicita::class)->findAll();
   return $this->render(
     'site/categoriasite.html.twig',array(
       'categoria' => $categoria,
       'articoli' => $articoli,
       'pubblicita' => $pubblicita
     ));
 }

 /**
 * @Route("/categoria/articoli/{id}", name="articolisite")
 */
 public function articolisiteAction(Request $request,$id)
 {
   $entityManager = $this->getDoctrine()->getManager();
   $articolo = $entityManager->getRepository(Articoli::class)->find($id);
   $articoli = $entityManager->getRepository(Articoli::class)->findByArticolo(self::DEFAULT_LIMIT);
   $pubblicita = $entityManager->getRepository(Pubblicita::class)->findAll();
   $commenti = new Commenti();
   $commenti->setArticoli($articolo);
   $form = $this->createForm(CommentiType::class, $commenti);
   $form->handleRequest($request);
   if ($form->isSubmitted() && $form->isValid()) {
     $user = $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');
     $user = $this->getUser();
     $commenti->setUserId($user);  //)
       // 4) save the User!
       $entityManager = $this->getDoctrine()->getManager();
       $commenti->setUserId($user);
       $entityManager->persist($commenti);
       $entityManager->flush();
   }
   return $this->render(
     'site/articolisite.html.twig',array(
       'articoli' => $articoli,
       'articolo' => $articolo,
       'pubblicita' => $pubblicita,
        'form' => $form->createView(),
     ));
 }

 /**
 * @Route("/likecomment/add/{id}", name="addlikecomment")
 */
 public function addlikecommentAction(Request $request,$id)
 {

   $entityManager = $this->getDoctrine()->getManager();
   $likecommenti = $entityManager->getRepository(Likecomment::class)->find($id);
   $commenti = new Likecomment();
   $form = $this->createForm(LikecommentType::class, $commenti);
   $form->handleRequest($request);
   if ($form->isSubmitted() && $form->isValid()) {
     $user = $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED');
     $user = $this->getUser();
     $commenti->setUserId($user);  //)
       // 4) save the User!
       $entityManager = $this->getDoctrine()->getManager();
       $commenti->setUserId($user);
       $entityManager->persist($commenti);
       $entityManager->flush();
   }
   return $this->render(
     'site/formlike.html.twig',array(
       'likecommenti'=> $likecommenti,
        'form' => $form->createView(),
     ));
 }

 /**
 * @Route("/likecomment/edit/{id}", name="editlikecomment")
 */
 public function editlikecommentAction(Request $request,$id)
 {
   $entityManager = $this->getDoctrine()->getManager();
   $likecommenti = $entityManager->getRepository(Likecomment::class)->find($id);
   $likecommenti->setLikecommenti($likecommenti->getLikecommenti());
   $form = $this->createForm(LikecommentType::class, $likecomment);
     // handle the first form
     $form->handleRequest($request);
     // control form //
     if($form->isSubmitted() &&  $form->isValid()){
        $likecomment = $form['likecomment']->getData();
       $sn = $this->getDoctrine()->getManager();
       $likecommenti = $sn->getRepository(Pubblicita::class)->find($id);
       $likecommenti->setLikecommenti($likecomment);
       $sn -> persist($likecommenti);
       $sn -> flush();
     }
   return $this->render(
     'site/formlike.html.twig',array(
       'likecommenti'=> $likecommenti,
        'form' => $form->createView(),
     ));
 }

     /**
    * @Route("/cookie", name="cookie")
    */
    public function cookieAction(Request $request)
    {
      return $this->render('site/cookie.html.twig');
    }

    /**
    * @Route("/ajax_get_articolo", name="ajax_get_articolo")
    * @Cache(vary={"X-Requested-With"})
    */
    public function ajaxArticoloAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $entityManager =  $this->getDoctrine()->getManager();

            $offsetarticolo = $request->get('offsetarticolo');

            $articoli = $entityManager->getRepository(Articoli::class)->findByArticolo(self::DEFAULT_LIMIT, $offsetarticolo);

            return $this->render('ajax/articoli_ajax.html.twig', array(
                'articoli' => $articoli,
            ));
        }

        throw new NotFoundHttpException("Page not found");
    }

    /**
    * @Route("/ajax_get_articolo_internal", name="ajax_get_articolo_internal")
    * @Cache(vary={"X-Requested-With"})
    */
    public function ajaxArticoloInternalAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $entityManager =  $this->getDoctrine()->getManager();

            $offsetarticolo = $request->get('offsetarticolo');

            $articoli = $entityManager->getRepository(Articoli::class)->findByArticolo(self::DEFAULT_LIMIT, $offsetarticolo);

            return $this->render('ajax/articoli_ajax_internal.html.twig', array(
                'articoli' => $articoli,
            ));
        }

        throw new NotFoundHttpException("Page not found");
    }


}
