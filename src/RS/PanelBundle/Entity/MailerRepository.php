<?php

namespace RS\PanelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MailerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MailerRepository extends EntityRepository
{
            // Cette requête permet de récupérer la liste des mail du formulaire client
    public function getMail()
    {
         $query = $this->createQueryBuilder('m')
            ->getQuery()
            ;
        return $query->getResult();
    }
    
              // Cette requête permet de récupérer la liste des mail du formulaire client
    public function getMailer()
    {
         $qb = $this
             ->createQueryBuilder('m')
             ->leftJoin('m.client', 'cli')
             ->addSelect('cli')
            
            ;
        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}
