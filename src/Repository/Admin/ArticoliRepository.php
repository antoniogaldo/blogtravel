<?php

namespace App\Repository\Admin;

use Doctrine\ORM\EntityRepository;

class ArticoliRepository extends \Doctrine\ORM\EntityRepository
{
  public function findFirst()
    {
      $qb = $this->createQueryBuilder('a');
      $qb->setMaxResults( 1 );
      $qb->orderBy('a.id', 'DESC');

      return $qb->getQuery()->getSingleResult();
    }
  public function findNews(){
    $qb = $this->createQueryBuilder('a');

  }

}
