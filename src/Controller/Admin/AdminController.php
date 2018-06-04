<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Admin\ArticolicategoriaType;
use App\Entity\Admin\Articolicategoria;
use App\Form\Admin\ArticoliType;
use App\Entity\Admin\Articoli;
use App\Entity\Security\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends Controller
{

  /**
  * @Route("/dashboard", name="dashboard")
  */
  public function dashboardAction()
  {
    return $this->render('admin/dashboard.html.twig');
  }

  /**
  * @Route("/user", name="user")
  */
  public function usersAction()
  {
    $em= $this->getDoctrine()->getManager();
    $user= $em->getRepository(User::class)->findAll();
    return $this->render('admin/user.html.twig', [
      'user' => $user

    ]);
  }

  /**
  * @Route("/user/view/{id}", name="view")
  */
  public function userviewAction(Request $request,$id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $user= $entityManager->getRepository(User::class)->find($id);
    return $this->render(
      'admin/viewuser.html.twig',array(
        'user' => $user
      ));
  }

  /**
  * @Route("/user/edit/{id}", name="edit")
  */
  public function updateAction(Request $request,$id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $user = $entityManager->getRepository(User::class)->find($id);
    $user->setUsername($user->getUsername());
    $user->setEmail($user->getEmail());
    $user->setIsActive($user->getIsActive());
    $user->setRoles($user->getRoles());
    if (!$user) {
      throw $this->createNotFoundException(
        'User non trovato'.$id
      );
    }
    $form = $this->createForm(UserType::class, $user);
    if ($request->isMethod('POST')) {
      // handle the first form
      $form->handleRequest($request);
      // control form //
      if($form->isSubmitted() &&  $form->isValid()){
        $username = $form['username']->getData();
        $email= $form['email']->getData();
        $isActive = $form['isActive']->getData();
        $roles = $form['roles']->getData();
        $sn = $this->getDoctrine()->getManager();
        $user = $sn->getRepository(User::class)->find($id);
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setIsActive($isActive);
        $user->setRoles($roles);
        $sn -> persist($user);
        $sn -> flush();
        $request->getSession()
        ->getFlashBag()
        ->add('success', 'Hai modificato un user');
      }
      else {
        // alert insucces //
        $request->getSession()
        ->getFlashBag()
        ->add('notsuccess', 'User gia presente');
      }
      return $this->redirectToRoute('user');
    }
    return $this->render('admin/edituser.html.twig', [
      'form' => $form->createView(),
      'user' => $user

    ]);
  }

  /**
  * @Route("/user/delete/{id}", name="delete")
  */
  public function deleteAction($id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $user = $entityManager->getRepository(User::class)->find($id);

    if (!$user) {
      throw $this->createNotFoundException(
        'User non trovato '.$id
      );
    }
    $entityManager->remove($user);
    $entityManager->flush();
    return $this->redirectToRoute('user');
  }

  /**
   * @Route("/addcategoria", name="addcategoria")
   */
  public function addcategoriaAction(Request $request)
  {
      $em= $this->getDoctrine()->getManager();
      $categoria= $em->getRepository(Articolicategoria::class)->findAll();
      // 1) build the form
      $articolicategoria = new Articolicategoria();
      $form = $this->createForm(ArticolicategoriaType::class, $articolicategoria);

      // 2) handle the submit (will only happen on POST)
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          // 4) save the User!
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($articolicategoria);
          $entityManager->flush();
          // ... do any other work - like sending them an email, etc
          // maybe set a "flash" success message for the user
          return $this->redirectToRoute('addcategoria');
      }

      return $this->render(
          'admin/addcategoria.html.twig',array(
            'form' => $form->createView(),
            'categoria' => $categoria,
            'articolicategoria' => $articolicategoria
          ));
  }

  /**
  * @Route("/categoria/delete/{id}", name="deletecategoria")
  */
  public function deletecategoriaAction($id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $categoria = $entityManager->getRepository(Articolicategoria::class)->find($id);

    if (!$categoria) {
      throw $this->createNotFoundException(
        'Categoria non trovato '.$id
      );
    }
    $entityManager->remove($categoria);
    $entityManager->flush();
    return $this->redirectToRoute('addcategoria');
  }

  /**
  * @Route("/categoria/edit/{id}", name="editcategoria")
  */
  public function editcategoriaAction(Request $request,$id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $categoria = $entityManager->getRepository(Articolicategoria::class)->find($id);
    $categoria->setNome($categoria->getNome());
    $categoria->setData($categoria->getData());
    if (!$categoria) {
      throw $this->createNotFoundException(
        'User non trovato'.$id
      );
    }
    $form = $this->createForm(ArticolicategoriaType::class, $categoria);
    if ($request->isMethod('POST')) {
      // handle the first form
      $form->handleRequest($request);
      // control form //
      if($form->isSubmitted() &&  $form->isValid()){
        $nome = $form['nome']->getData();
        $data= $form['data']->getData();
        $sn = $this->getDoctrine()->getManager();
        $categoria = $sn->getRepository(Articolicategoria::class)->find($id);
        $categoria->setNome($nome);
        $categoria->setData($data);
        $sn -> persist($categoria);
        $sn -> flush();
        $request->getSession()
        ->getFlashBag()
        ->add('success', 'Hai modificato una categoria');
      }
      else {
        // alert insucces //
        $request->getSession()
        ->getFlashBag()
        ->add('notsuccess', 'Categoria gia presente');
      }
      return $this->redirectToRoute('addcategoria');
    }
    return $this->render('admin/editcategoria.html.twig', [
      'form' => $form->createView(),
      'categoria' => $categoria

    ]);
  }

  /**
  * @Route("/categoria/view/{id}", name="viewcategoria")
  */
  public function categoriaviewAction(Request $request,$id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $categoria = $entityManager->getRepository(Articolicategoria::class)->find($id);
    return $this->render(
      'admin/viewcategoria.html.twig',array(
        'categoria' => $categoria
      ));
  }

  /**
   * @Route("/addarticoli", name="addarticoli")
   */
  public function addarticoliAction(Request $request)
  {
      $em= $this->getDoctrine()->getManager();
      $articoliwrite= $em->getRepository(Articoli::class)->findAll();
      // 1) build the form
      $articoli = new Articoli();
      $form = $this->createForm(ArticoliType::class, $articoli);

      // 2) handle the submit (will only happen on POST)
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          // 4) save the User!
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($articoli);
          $entityManager->flush();
          // ... do any other work - like sending them an email, etc
          // maybe set a "flash" success message for the user
          return $this->redirectToRoute('addarticoli');
      }

      return $this->render(
          'admin/addarticoli.html.twig',array(
            'form' => $form->createView(),
            'articoliwrite' => $articoliwrite
          ));
  }

  /**
  * @Route("/articoli/delete/{id}", name="deletearticoli")
  */
  public function deletearticoliAction($id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $articoli = $entityManager->getRepository(Articoli::class)->find($id);

    if (!$articoli) {
      throw $this->createNotFoundException(
        'Articoli non trovato '.$id
      );
    }
    $entityManager->remove($articoli);
    $entityManager->flush();
    return $this->redirectToRoute('addcategoria');
  }

  /**
  * @Route("/articoli/edit/{id}", name="editarticoli")
  */
  public function editarticoliAction(Request $request,$id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $articoli = $entityManager->getRepository(Articoli::class)->find($id);
    $articoli->setActive($articoli->getActive());
    $articoli->setTitolo($articoli->getTitolo());
    $articoli->setData($articoli->getData());
    $articoli->setTags($articoli->getTags());
    $articoli->setArticolo($articoli->getArticolo());
    $articoli->setAutore($articoli->getAutore());
    $articoli->setCategoria($articoli->getCategoria());
    if (!$articoli) {
      throw $this->createNotFoundException(
        'Articoli non trovato'.$id
      );
    }
    $form = $this->createForm(ArticoliType::class, $articoli);
    if ($request->isMethod('POST')) {
      // handle the first form
      $form->handleRequest($request);
      // control form //
      if($form->isSubmitted() &&  $form->isValid()){
        $active = $form['active']->getData();
        $titolo = $form['titolo']->getData();
        $data= $form['data']->getData();
        $articolo= $form['articolo']->getData();
        $tags= $form['tags']->getData();
        $autore = $form['autore']->getData();
        $categoria= $form['categoria']->getData();
        $sn = $this->getDoctrine()->getManager();
        $articoli = $sn->getRepository(Articoli::class)->find($id);
        $articoli->setActive($active);
        $articoli->setTitolo($titolo);
        $articoli->setData($data);
        $articoli->setTags($tags);
        $articoli->setArticolo($articolo);
        $articoli->setAutore($autore);
        $articoli->setCategoria($categoria);
        $sn -> persist($articoli);
        $sn -> flush();
        $request->getSession()
        ->getFlashBag()
        ->add('success', 'Hai modificato un articolo');
      }
      else {
        // alert insucces //
        $request->getSession()
        ->getFlashBag()
        ->add('notsuccess', 'Articolo gia presente');
      }
      return $this->redirectToRoute('addarticoli');
    }
    return $this->render('admin/editarticoli.html.twig', [
      'form' => $form->createView(),
      'articoli' => $articoli

    ]);
  }

  /**
  * @Route("/articoli/view/{id}", name="viewarticoli")
  */
  public function articoliviewAction(Request $request,$id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $articoli = $entityManager->getRepository(Articoli::class)->find($id);
    return $this->render(
      'admin/viewarticoli.html.twig',array(
        'articoli' => $articoli
      ));
  }

}
