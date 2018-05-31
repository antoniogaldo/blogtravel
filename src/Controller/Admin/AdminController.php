<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Security\UserType;
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

}
