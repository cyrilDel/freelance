<?php

namespace RS\PanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use RS\PanelBundle\Entity\Client;
use RS\PanelBundle\Form\ClientType;

use RS\PanelBundle\Entity\Travaux;
use RS\PanelBundle\Form\TravauxType;

use RS\PanelBundle\Entity\Mailer;
use RS\PanelBundle\Form\MailerType;

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
            ->getClientProfil()
             ; 
        
        // AFFICHAGE DES Mail
        $listMailer = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Mailer')
            ->getMailer()
             ;  
           
        return $this->render('RSPanelBundle:Panel:boitemail.html.twig', array(
            'listeClients' => $listClients,
            'listmailer'   => $listMailer
        ));
    }
    
    // liste des clients
    public function listeclientsAction()
    {
        // AFFICHAGE DES PROFILS
        $listClients = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Client')
            ->getClientProfil()
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
            ->getUserProfil()
            ;  
        
        return $this->render('RSPanelBundle:listes:listusers.html.twig', array(
            'listUsers'  => $listUsers   
        ));
    }
    
    // Assigner un client a un mail reçu
    public function assignerclientAction($id, Request $request)
    {
        $client = new Client();
        
        // On appel l'entité déja crée dans la Bdd pour la modifier
        $mailer = $this->getDoctrine()
            ->getManager()
            ->getRepository('RSPanelBundle:Mailer')
            ->find($id)
            ;
        
        // On créer le FormBuilder avec le service form factory
        $form = $this->get('form.factory')->create(new ClientType(), $client);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $mailer->setClient($client);
            $em->persist($client);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Client ajouté avec succés!');
            
            return $this->redirect($this->generateUrl('rs_panel_boitemail'));
        }
        
        return $this->render('RSPanelBundle:formulaire:assignerclient.html.twig', array(
            'form'   => $form->createView(),
            'id'     => $id,
           
        ));
    }
    
    // La vue Fiche Client
    public function clientAction($id, Request $request)
    {
        $session = $this->getRequest()->getSession();       
        $em = $this->getDoctrine()->getManager();
            
        $client = $em
            ->getRepository('RSPanelBundle:Client')
            ->find($id)
            ;
        
         $travaux = new Travaux();
        
        if (null === $client) {
        throw new NotFoundHttpException("Ce client n° ".$id." n'existe pas.");
        }
        
        if($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
         $travaux = new Travaux();
        
         // FORMULAIRE TRAVAUX
        $form = $this->get('form.factory')->create(new TravauxType(), $travaux);

        if ($form->handleRequest($request)->isValid()) {
            $travaux->setClient($client);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->persist($travaux);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Travaux ajouté avec succés!');
            
            return $this->redirect($this->generateUrl('rs_panel_client',array(
                'id'       => $id,
                'client'   => $client,
                'travaux'  => $travaux
            ) ));
        }
           
        return $this->render('RSPanelBundle:Panel:client.html.twig',array(
            'form'     => $form->createView(),
            'id'       => $id,
            'client'   => $client,
            'panier'   => $panier,
            'travaux'  => $travaux   
        ));
    }
    
    // la vue du formulaire "ajouter une action a un client
    public function addAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $client = $em
            ->getRepository('RSPanelBundle:Client')
            ->find($id)
            ;
        
        if (null === $client) {
        throw new NotFoundHttpException("Ce client n° ".$id." n'existe pas.");
        }
        
        $travaux = new Travaux();
        
         // FORMULAIRE TRAVAUX
        $form = $this->get('form.factory')->create(new TravauxType(), $travaux);

        if ($form->handleRequest($request)->isValid()) {
            $travaux->setClient($client);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->persist($travaux);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('info', 'Travaux ajouté avec succés!');
            
            return $this->redirect($this->generateUrl('rs_panel_panier',array(
                'id'       => $id,
                'client'   => $client,
                'travaux'  => $travaux
            ) ));
        }
        
        return $this->render('RSPanelBundle:Panel:addtravaux.html.twig',array(
            'form'     => $form->createView(),
            'id'       => $id,
            'client'   => $client,
            'travaux'  => $travaux
        ));
    }
}
