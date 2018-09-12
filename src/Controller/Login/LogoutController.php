<?php

namespace AppBundle\Controller\Login;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LogoutController extends Controller
{
    public function logoutAction(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();
        }

        return $this->redirectToRoute('homepage');
    }
}
