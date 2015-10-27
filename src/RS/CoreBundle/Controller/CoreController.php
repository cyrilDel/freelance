<?php

namespace RS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;


class CoreController extends Controller
{
    // La page d'accueil   
    public function indexAction()
    {
        return $this->render('RSCoreBundle:Core:index.html.twig');
    }

    
}
