<?php

namespace AppBundle\Controller\Login;

use AppBundle\Entity\User\User;
use AppBundle\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class BaseLoginController extends Controller
{
    protected function doLogin(User $user)
    {
        $token   = new UsernamePasswordToken($user, $user->getPassword(), 'fos_userbundle', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
    }

    protected function redirectAfterLogin(User $user)
    {
        if ($user instanceof User) {
            return $this->redirectToRoute('homepage');
        }

        throw new RuntimeException(sprintf('Unhandled user type: "%s".', get_class($user)));
    }
}
