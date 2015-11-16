<?php

namespace RS\PanelBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommandesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandesRepository extends EntityRepository
{
    public function byFacture($client)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.client = :client')
            ->andWhere('u.valider = 1')
            ->andWhere('u.reference = 1')
            ->orderBy('u.id')
            ->setParameter('client', $client)
            ;
        return $qb
            ->getQuery()
            ->getResult();
    }
    
     public function byFactur()
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->andWhere('u.valider = 1')
            ->andWhere('u.reference = 1')
            ->orderBy('u.id')
           ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    
}
