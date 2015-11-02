<?php

namespace RS\FactureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FactureController extends Controller
{ 
    public function facturesAction()
    {
        return $this->render('RSFactureBundle:Facture:facture.html.twig');
    }
    
    
    public function facturesPDFAction($id)
    {
        
        
        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('rs_facture_facture'));
        }
        
        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');
        $response = new Response;
        $response->headers->set('Content-type' , 'application/pdf');
        
        return $response;
    }
}
