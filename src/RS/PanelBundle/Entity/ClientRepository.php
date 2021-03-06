<?php

namespace RS\PanelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends EntityRepository
{
        // Cette requête permet de récupérer la liste des clients
    public function getClientProfil()
    {
        $query = $this->createQueryBuilder('c')
           
            ->getQuery()
            ;
        return $query->getResult();
    }
    
    public function findArray($array)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.id IN (:array)')
            ->setParameter('array', $array)
            ;
        
        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
    
}
