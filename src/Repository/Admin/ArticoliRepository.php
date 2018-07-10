<?php

namespace App\Repository\Admin;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ArticoliRepository extends \Doctrine\ORM\EntityRepository
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
  public function findByArticolo($limit, $offsetarticolo = null){
    $qb = $this->createQueryBuilder('a');
    $qb->orderBy('a.id', 'DESC');
    if($offsetarticolo) {
        $qb
            ->setFirstResult($offsetarticolo)
        ;
    }
    $qb->setMaxResults($limit);

    return $qb->getQuery()->getResult();
  }

  public function findTags(){
    $qb = $this->createQueryBuilder('a');
    $qb->select('a.tags');
    $qb->orderBy('a.tags', 'DESC');
    return $qb->getQuery()->getResult();
  }

  public function findCategoria(){
    $qb = $this->createQueryBuilder('a');
    $qb->setMaxResults( 1 );
    $qb->orderBy('a.categoria', 'DESC');
    return $qb->getQuery()->getResult();
  }

}
