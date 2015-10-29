<?php

namespace RS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

use RS\PanelBundle\Entity\Mailer;

use RS\PanelBundle\Form\MailerType;

class CoreController extends Controller
{
    // La page d'accueil   
    public function indexAction(Request $request)
    {
        // On cr�er l'objet Mailer
        $mailer = new Mailer();

        // On cr�er le FormBuilder avec le service form factory
        $form = $this->get('form.factory')->create(new MailerType(), $mailer);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailer);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Message envoy� avec succ�s!');

            return $this->redirect($this->generateUrl('rs_core_homepage' ));
        }

        //On passe la m�thode createView() du formulaire a la vue pour l'afficher
        return $this->render('RSCoreBundle:Core:index.html.twig', array(
            'form'  => $form->createView(),

        ));
    }


}
