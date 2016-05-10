<?php
namespace RS\FactureBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GetDevis
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
       
    }
      
    
    public function devis($devis)
    {
        $html = $this->container->get('templating')->render('RSFactureBundle:facture:devisPDF.html.twig', 
        array('devis' => $devis));
        
        $html2pdf = new \Html2Pdf_Html2Pdf('P','A4','fr');
        $html2pdf->pdf->SetAuthor('Cyril Delage, Développeur Web');
        $html2pdf->pdf->SetTitle('devis ');
        $html2pdf->pdf->SetSubject('devis Cyril Delage, Freelance: Développeur web');
        $html2pdf->pdf->SetKeywords('devis Cyril Delage, Freelance, Développeur web');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        //$html2pdf->Output('devis.pdf');
        
        return $html2pdf;
        
    }
}