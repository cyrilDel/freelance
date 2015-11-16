<?php

namespace RS\FactureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use RS\PanelBundle\Entity\Commandes;

class FactureController extends Controller
{ 

    public function facturesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $commandes =  $em->getRepository('RSPanelBundle:Commandes')->findAll();
        
        return $this->render('RSFactureBundle:facture:facture.html.twig', array('commandes' => $commandes));
    }

  
    public function showFactureAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $facture = $em->getRepository('RSPanelBundle:Commandes')->find($id);
        
        if (!$facture) {
            $this->get('session')->getFlashBag()->add('error', 'Une erreur est survenue');
            return $this->redirect($this->generateUrl('rs_facture_facture'));
        }
        
        $this->container->get('setNewFacture')->facture($facture)->Output('Facture.pdf');
        $response = new Response();
        $response->headers->set('Content-type' , 'application/pdf');
        
        return $response;
    }
    
    
}
