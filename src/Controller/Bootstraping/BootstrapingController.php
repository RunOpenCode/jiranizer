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
}
