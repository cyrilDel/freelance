<?php

namespace RS\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use RS\PanelBundle\Entity\Client;

use RS\PanelBundle\Form\ClientType;

class PanelController extends Controller
{
    public function indexAction(Request $request)
    {
        $client = new Client();
        
        // On créer le FormBuilder avec le service form factory
        $form = $this->get('form.factory')->create(new ClientType(), $client);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Client ajouté avec succés!');
            
            return $this->redirect($this->generateUrl('rs_panel_homepage'));
        }

        return $this->render('RSPanelBundle:Panel:index.html.twig', array(
            'form'  => $form->createView(),
        ));
    }

    //    formulaire devis
    public function devisformAction()
    {
        return $this->render('RSPanelBundle:formulaire:devisform.html.twig');
    }

    //  Formulaire factures
    public function factureformAction()
    {
        return $this->render('RSPanelBundle:formulaire:factureform.html.twig');
    }
    
    //  Boite mail
    public function boitemailAction()
    {
        // AFFICHAGE DES PROFILS
        $listClients = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Client')
            -> getClientProfil()
             ;  
        
        
        return $this->render('RSPanelBundle:Panel:boitemail.html.twig', array(
            'listeClients' => $listClients
        ));
    }
    
       // liste toutes les factures des clients
    public function facturesclientsAction()
    {
        return $this->render('RSPanelBundle:listes:facturesclients.html.twig');
    }
    
    // liste tout les devis des clients
    public function devisclientsAction()
    {
        return $this->render('RSPanelBundle:listes:devisclients.html.twig');
    }
    
    // liste des clients
    public function listeclientsAction()
    {
        // AFFICHAGE DES PROFILS
        $listClients = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Client')
            -> getClientProfil()
             ;  
        
        
        return $this->render('RSPanelBundle:listes:listeclients.html.twig', array(
            'listeClients' => $listClients
        ));
    }
    
     // liste des utilisateurs
    public function listusersAction()
    {
        // AFFICHAGE DES PROFILS
        $listUsers = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSUserBundle:User')
            -> getUserProfil()
             ;  
        
        return $this->render('RSPanelBundle:listes:listusers.html.twig', array(
            'listUsers'  => $listUsers   
        ));
    }
    
}
