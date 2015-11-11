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

    public function devisformAction()
    {
        return $this->render('RSPanelBundle:Panel:devisform.html.twig');
    }

    public function factureformAction()
    {
        return $this->render('RSPanelBundle:Panel:factureform.html.twig');
    }
}
