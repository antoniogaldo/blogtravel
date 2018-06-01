<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Admin\ArticolicategoriaType;
use App\Entity\Admin\Articolicategoria;
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

}
