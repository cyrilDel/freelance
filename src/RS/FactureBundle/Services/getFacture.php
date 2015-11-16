<?php
namespace RS\FactureBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GetFacture
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
       
    }
      
    public function facture($facture)
    {
        $html = $this->container->get('templating')->render('RSFactureBundle:facture:facturePDF.html.twig', 
        array('facture' => $facture));
        
        $html2pdf = new \Html2Pdf_Html2Pdf('P','A4','fr');
        $html2pdf->pdf->SetAuthor('Cyril Delage, Développeur Web');
        $html2pdf->pdf->SetTitle('Facture ');
        $html2pdf->pdf->SetSubject('Facture Cyril Delage, Freelance: Développeur web');
        $html2pdf->pdf->SetKeywords('Facture Cyril Delage, Freelance, Développeur web');
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($html);
        //$html2pdf->Output('Facture.pdf');
        
        return $html2pdf;
        
    }
}