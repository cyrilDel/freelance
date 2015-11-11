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
        // On créer l'objet Mailer
        $mailer = new Mailer();

        // On créer le FormBuilder avec le service form factory
        $form = $this->get('form.factory')->create(new MailerType(), $mailer);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mailer);
            $em->flush();
            
            // mail de validation
            $message = \Swift_Message::newInstance()
                ->setSubject('Nouveau message sur creer-monsite.fr')
                ->setFrom('cdelage.dev@gmail.com')
                ->setTo('cdelage.dev@gmail.com')
                ->setCharset('utf-8')
                ->setContentType('text/html')
                ->setBody( $this->renderView(
                    'RSCoreBundle:Core:mail.html.twig',
                    array(
                        'objet' =>  $form->get('objet')->getData(),
                        'courriel' => $form->get('courriel')->getData(),
                        'message' => $form->get('message')->getData()
                    )
                )
            );

            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('notice', 'Message envoyé avec succés!');

            return $this->redirect($this->generateUrl('rs_core_homepage' ));
        }

        return $this->render('RSCoreBundle:Core:index.html.twig', array(
            'form'  => $form->createView(),
        ));
    }
    
    // Menu dashboard
    public function menuAction()
    {
        return $this->render('RSCoreBundle:Core:menu.html.twig');      
    }
    

    public function mentionslegalesAction()
    {
        return $this->render('RSCoreBundle:Core:mentionslegales.html.twig');
    }
}
