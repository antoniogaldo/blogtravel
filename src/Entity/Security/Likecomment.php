<?php

namespace App\Entity\Security;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Security\User;
use App\Entity\Admin\Articoli;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user__likecomment")
 * @ORM\Entity(repositoryClass="App\Repository\Security\LikecommentRepository")
 * @UniqueEntity(
  *     fields={"user_id"},
  *     errorPath="user_id",
  *     message="This port is already in use on that host."
  * )
 */
class Likecomment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
      * @var boolean
      *
      * @ORM\Column(name="likecommenti", type="boolean",nullable=true)
      */
     private $likecommenti;

    /**
      *
      * @ORM\ManyToOne(targetEntity="App\Entity\Admin\Articoli", cascade={"persist"})
      * @ORM\JoinColumn(name="articoli_id", referencedColumnName="id")
      */
     private $articoli_id;

     /**
       *
       * @ORM\ManyToOne(targetEntity="User")
       * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
       */
      private $user_id;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set likecommenti
     *
     * @param boolean $likecommenti
     *
     * @return Likecomment
     */
    public function setLikecommenti($likecommenti)
    {
        $this->likecommenti = $likecommenti;

        return $this;
    }

    /**
     * Get likecommenti
     *
     * @return boolean
     */
    public function getLikecommenti()
    {
        return $this->likecommenti;
    }

    /**
     * Set integer articoli_id
     *
     * @param App\Entity\Admin\Articoli $articoli_id
     * @return Likecomment
     */
    public function setArticoliId(App\Entity\Admin\Articoli $articoli_id=null)
    {
        $this->articoli_id = $articoli_id;

        return $this;
    }

    /**
     * Get articoli_id
     *
     * @return App\Entity\Admin\Articoli
     */
    public function getArticoliId()
    {
        return $this->articoli_id;
    }

    /**
     * Set integer user_id
     *
     * @param User $userId
     * @return Likecomment
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return User
     */
    public function getUserId()
    {
        return $this->user_id;
    }

}
