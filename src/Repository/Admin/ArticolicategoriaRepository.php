<?php

namespace App\Repository\Admin;

use Doctrine\ORM\EntityRepository;

class ArticolicategoriaRepository extends \Doctrine\ORM\EntityRepository
{
  public function findByCategoria($limit, $offsetcategoria = null){
    $qb = $this->createQueryBuilder('c');
    $qb->orderBy('c.id', 'DESC');
    if($offsetcategoria) {
        $qb
            ->setFirstResult($offsetcategoria)
        ;
    }
    $qb->setMaxResults($limit);

    return $qb->getQuery()->getResult();
  }
  public function findCategoria(){

          $qb = $this->createQueryBuilder('c');

          $qb
              ->where('c.active = 0')
          ;
          return $qb->getQuery()->getResult();

  }

}
