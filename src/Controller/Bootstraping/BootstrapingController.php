<?php

namespace App\Controller\Bootstraping;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BootstrapingController extends Controller
{
    public function bootstrapingAction(Request $request)
    {
        return $this->render('_bootstraping/index.html.twig');
    }

    public function blankAction(Request $request)
    {
        return $this->render('_bootstraping/blank.html.twig');
    }

    public function buttonsAction(Request $request)
    {
        return $this->render('_bootstraping/buttons.html.twig');
    }

    public function flotAction(Request $request)
    {
        return $this->render('_bootstraping/flot.html.twig');
    }

    public function formsAction(Request $request)
    {
        return $this->render('_bootstraping/forms.html.twig');
    }

    public function gridAction(Request $request)
    {
        return $this->render('_bootstraping/grid.html.twig');
    }

    public function iconsAction(Request $request)
    {
        return $this->render('_bootstraping/icons.html.twig');
    }

    public function loginAction(Request $request)
    {
        return $this->render('_bootstraping/login.html.twig');
    }

    public function morrisAction(Request $request)
    {
        return $this->render('_bootstraping/morris.html.twig');
    }
}
