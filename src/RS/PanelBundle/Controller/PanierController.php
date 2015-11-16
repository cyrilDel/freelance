<?php

namespace RS\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use RS\PanelBundle\Entity\Client;
use RS\PanelBundle\Form\ClientType;

use RS\PanelBundle\Entity\Travaux;
use RS\PanelBundle\Form\TravauxType;

use RS\PanelBundle\Entity\Mailer;
use RS\PanelBundle\Form\MailerType;

class PanierController extends Controller{
    
    public function panierAction()
    {
       $session = $this->getRequest()->getSession();
      
        if (!$session->has('panier')) $session->set('panier', array());
        
        $em = $this->getDoctrine()->getManager();
       
         $listeTravaux = $em
            ->getRepository('RSPanelBundle:Travaux')
            ->findArray(array_keys($session->get('panier')))
            ;
       
         $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Travaux')
            ;
        $toutlestravaux = $repository->myFindAll();

        return $this->render('RSPanelBundle:panier:panier.html.twig',array(
            'listeTravaux'   => $listeTravaux,
            'toutlestravaux' => $toutlestravaux,
            'panier'         => $session->get('panier')
        ));
    }
    
    // methode pour ajouter un article au panier
    public function ajouterAction($id)
    {
        $session = $this->getRequest()->getSession();
        
        if (!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');
        
        //$panier[ID DU PRODUIT] => QUANTITE
        
        // On verifie la quantité de l'article deja présente dans le panier, si la quantité est = au moin a 1, on change la valeure de quantité par une nouvelle valeure
        // Sinon, on verifie que la quantité n'est pas null, et si elle est null, on redirige vers la page panier 
        if (array_key_exists($id, $panier)) {
            if ($this->getRequest()->query->get('qte') != null) $panier[$id] = $this->getRequest()->query->get('qte');
             $this->get('session')->getFlashBag()->add('success', 'quantité modifiée avec succès');
        } else {
            if ($this->getRequest()->query->get('qte') != null)
                $panier[$id] = $this->getRequest()->query->get('qte');
            else
                $panier[$id] = 1;
        }
        
        // Ensuite on met a jour la recette dans la session panier
        $session->set('panier', $panier);
        $this->get('session')->getFlashBag()->add('success', 'Travaux ajouté à votre panier avec succès');
        
        return $this->redirect($this->generateUrl('rs_panel_panier'));
    }
    
    public function reservationAction(request $request)
    {
        $session = $this->getRequest()->getSession();
           
        if($session->has('client'))
            $panier = $session->get('client');
        else
            $panier = false;
        
        // Session ADRESSE client
        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');

        // AFFICHAGE DES PROFILS
        $listClients = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Client')
            ->getClientProfil()
            ; 

        return $this->render('RSPanelBundle:Panel:reservation.html.twig', array(
            'listClients'    => $listClients,
            'panier'         => $session->get('panier')
        ));
    }
    
    public function setReservationOnSession()
    {
        $session = $this->getRequest()->getSession();
        
        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');
        
        if ($this->getRequest()->request->get('livraison') != null)
        {
            $adresse['livraison'] = $this->getRequest()->request->get('livraison');
        } else {
            return $this->redirect($this->generateUrl ('rs_panel_validation'));
        }
        
        $session->set('adresse', $adresse);
        return $this->redirect($this->generateUrl ('rs_panel_validation'));
         var_dump($adresse);
        die();
    }

    // Méthode pour valider le panier
    public function validationAction()
    {
     if ($this->get('request')->getMethod() == 'POST')
            $this->setReservationOnSession();
        
        $em = $this->getDoctrine()->getManager();
        $prepareCommande = $this->forward('RSPanelBundle:Commandes:prepareCommande');
        $commande = $em->getRepository('RSPanelBundle:Commandes')->find($prepareCommande->getContent());
   
        /*
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession(); 
        $adresse = $session->get('adresse');
         $listeTravaux = $em->getRepository('RSPanelBundle:Travaux')->findArray(array_keys($session->get('panier')));
        $livraison =  $em->getRepository('RSPanelBundle:Client')->find($adresse['livraison']);
     */
      //  var_dump($commande);
       // die();
        return $this->render('RSPanelBundle:Panel:validation.html.twig', array(
             'commande'       => $commande
        ));
    }
}