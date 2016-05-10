<?php

namespace RS\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use RS\PanelBundle\Entity\Commandes;
use RS\PanelBundle\Entity\Client;
use RS\PanelBundle\Entity\Travaux;

class CommandesController extends Controller{
    
    public function facture()
    {
        $em = $this->getDoctrine()->getManager();
        $generator = $this->container->get('security.secure_random'); // Token pour l'API
        $session = $this->getRequest()->getSession();
        $adresse = $session->get('adresse');
        $panier = $session->get('panier');
        $commande = array();
        $totalTTC = 0;
        
        $livraison = $em->getRepository('RSPanelBundle:Client')->find($adresse['livraison']);
        $listeTravaux = $em->getRepository('RSPanelBundle:Travaux')->findArray(array_keys($session->get('panier')));
        
        foreach($listeTravaux as $travaux)
        {
         
            $prixTTC = ($travaux->getTarifheure() * $panier[$travaux->getId()]);
            $totalTTC += $prixTTC;

            $commande['travaux'][$travaux->getId()] = array('reference'     => $travaux->getAction(),
                                                            'tarifheure'    => $travaux->getTarifheure(),
                                                            'nombresheures' => $panier[$travaux->getId()],
                                                            'prixTTC'       => round($travaux->getTarifheure()),
                                                            'datedelivraison' => $travaux->getDatedelivraison()
                                                              );
            
        }  
        
        $commande['livraison'] = array('nom'     => $livraison->getName(),
                                       'adresse' => $livraison->getAdresse(),
                                       'ville'   => $livraison->getVille(),
                                      );
        
        $commande['prixTTC'] = round($totalTTC,2);
        $commande['token'] = bin2hex($generator->nextBytes(20));
        
        return $commande;
    
    }
    
    public function prepareCommandeAction()
    {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        
        
        if (!$session->has('commande'))
        {
            $commande = new Commandes();
        }
        else {
            $commande = $em->getRepository('RSPanelBundle:Commandes')->find($session->get('commande'));
        }
        
        $commande->setDate(new \DateTime());
    //  $commande->setClient($this->getClient());
       
        $commande->setValider(0);
        $commande->setReference(0);
        $commande->setCommande($this->facture());
        
       
        if (!$session->has('commande')) {
            $em->persist($commande);
            $session->set('commande',$commande);
        }
        
        $em->flush();
        
        return new Response($commande->getId());
    }
    
    public function validationCommandeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('RSPanelBundle:Commandes')->find($id);
        
        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');
        
        $commande->setValider(1);
        $commande->setReference(1);  //Service
        $em->flush();   
        
        $session = $this->getRequest()->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
              
        $this->get('session')->getFlashBag()->add('success','Votre commande est validée avec succès');
        return $this->redirect($this->generateUrl('rs_facture_facture'));
    }   
    
    public function devisValidationCommandeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository('RSPanelBundle:Commandes')->find($id);
        
        if (!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException('La commande n\'existe pas');
        
        $commande->setValider(1);
        $commande->setReference(1);  //Service
        $em->flush();   
        
        $session = $this->getRequest()->getSession();
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
              
        $this->get('session')->getFlashBag()->add('success','Votre commande est validée avec succès');
        return $this->redirect($this->generateUrl('rs_facture_devis'));
    }   
}