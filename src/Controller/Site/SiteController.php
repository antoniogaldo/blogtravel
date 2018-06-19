<?php

namespace App\Controller\Site;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Security\UserType;
use App\Entity\Security\User;
use App\Form\Admin\ArticolicategoriaType;
use App\Entity\Admin\Articolicategoria;
use App\Form\Admin\ArticoliType;
use App\Entity\Admin\Articoli;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SiteController extends Controller
{
  /**
   * @Route("/home", name="home")
   */
  public function homeAction()
  {
   $entityManager = $this->getDoctrine()->getManager();
   $home = $entityManager->getRepository(Articoli::class)->findFirst();
   $news = $entityManager->getRepository(Articoli::class)->findAll();
   $articoli = $entityManager->getRepository(Articoli::class)->findCategoria();
   $categoria = $entityManager->getRepository(Articolicategoria::class)->findAll();
   return $this->render('site/index.html.twig',array(
     'home' => $home,
     'news' => $news,
     'categoria' => $categoria,
     'articoli' => $articoli
   ));
 }

 /**
 * @Route("/categoria/{id}", name="categoriasite")
 */
 public function categoriasiteAction(Request $request,$id)
 {
   $entityManager = $this->getDoctrine()->getManager();
   $categoria = $entityManager->getRepository(Articolicategoria::class)->find($id);
   return $this->render(
     'site/categoriasite.html.twig',array(
       'categoria' => $categoria,
     ));
 }

 /**
 * @Route("/categoria/articoli/{id}", name="articolisite")
 */
 public function articolisiteAction(Request $request,$id)
 {
   $entityManager = $this->getDoctrine()->getManager();
   $articoli = $entityManager->getRepository(Articoli::class)->find($id);
   return $this->render(
     'site/articolisite.html.twig',array(
       'articoli' => $articoli,
     ));
 }
}
