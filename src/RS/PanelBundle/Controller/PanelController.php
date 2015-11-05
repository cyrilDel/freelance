<?php

namespace RS\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanelController extends Controller
{
    public function indexAction()
    {
        return $this->render('RSPanelBundle:Panel:index.html.twig');
    }

    public function devisformAction()
    {
        return $this->render('RSPanelBundle:Panel:devisform.html.twig');
    }

    public function factureformAction()
    {
        return $this->render('RSPanelBundle:Panel:factureform.html.twig');
    }
}
