<?php

namespace App\Repository\Security;

use Doctrine\ORM\EntityRepository;
use App\Entity\Admin\Articoli;

class CommentiRepository extends \Doctrine\ORM\EntityRepository
{
  public function findByArticolo(){
  }
}
