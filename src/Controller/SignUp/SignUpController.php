<?php

namespace AppBundle\Controller\SignUp;

use AppBundle\Entity\User\User;
use AppBundle\Form\SignUp\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SignUpController extends Controller
{
    public function signUpAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $user->setPlainPassword($user->getPassword());
            $user->setPassword(null);

            $this->get('fos_user.user_manager')->updateUser($user);

            $user->setUsername($user->getUsername());
            $user->setEnabled(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'fos_userbundle', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/sign_up/generic/sign_up.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
