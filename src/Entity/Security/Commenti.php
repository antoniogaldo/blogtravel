<?php

namespace App\Entity\Security;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Security\User;

/**
 * @ORM\Table(name="user__commenti")
 * @ORM\Entity(repositoryClass="App\Repository\Security\CommentiRepository")
 */
class Commenti
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
      * @ORM\Column(name="likecomment", type="boolean",nullable=true)
      */
     private $likecomment;

     /**
      * @ORM\Column(type="string", length=1000)
      */
     private $commenti;


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
     * Set likecomment
     *
     * @param boolean $likecomment
     *
     * @return Commenti
     */
    public function setLikecomment($likecomment)
    {
        $this->likecomment = $likecomment;

        return $this;
    }

    /**
     * Get likecomment
     *
     * @return boolean
     */
    public function getLikecomment()
    {
        return $this->likecomment;
    }

    /**
     * Set commenti
     *
     * @param string commenti
     *
     * @return Commenti
     */
    public function setCommenti($commenti)
    {
        $this->commenti = $commenti;

        return $this;
    }

    /**
     * Get commenti
     *
     * @return string
     */
    public function getCommenti()
    {
        return $this->commenti;
    }
    /**
     * Set integer user_id
     *
     * @param User $userId
     * @return Commenti
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
