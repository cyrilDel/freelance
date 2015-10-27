<?php

namespace RS\FactureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RSFactureBundle:Default:index.html.twig', array('name' => $name));
    }
}
