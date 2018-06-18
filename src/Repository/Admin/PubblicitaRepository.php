<?php

namespace App\Repository\Admin;

use Doctrine\ORM\EntityRepository;

class PubblicitaRepository extends \Doctrine\ORM\EntityRepository
{
  public function findFirst()
    {
      $qb = $this->createQueryBuilder('a');
      $qb->setMaxResults( 1 );
      $qb->orderBy('a.id', 'DESC');
      return $qb->getQuery()->getOneOrNullResult();
    }
  public function findNews(){
    $qb = $this->createQueryBuilder('a');

  }

}
