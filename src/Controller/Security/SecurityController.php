<?php

namespace App\Controller\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Security\UserType;
use App\Form\Security\RegisterType;
use App\Entity\Security\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{
  /**
   * @Route("/", name="entry")
   */
   public function entryAction(Request $request)
   {
       return $this->redirect($this->generateUrl('home'));
   }

   /**
    * @Route("/login", name="login")
    */
   public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
   {
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
  }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em= $this->getDoctrine()->getManager();
        $users= $em->getRepository(User::class)->findAll();
        // 1) build the form
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirectToRoute('home');
        }

        return $this->render(
            'security/register.html.twig',array(
              'form' => $form->createView(),
              'users' => $users
            ));
    }

    /**
    * @Route("/user", name="user")
    */
    public function usersAction()
    {
      $em= $this->getDoctrine()->getManager();
      $user= $em->getRepository(User::class)->findAll();
      return $this->render('security/user.html.twig', [
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
        'security/viewuser.html.twig',array(
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
      return $this->render('security/edituser.html.twig', [
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
