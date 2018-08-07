<?php

namespace App\Entity\Admin;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="pubblicita")
 * @ORM\Entity(repositoryClass="App\Repository\Admin\PubblicitaRepository")
 */
class Pubblicita
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $compagnia;

    /**
      * @var boolean
      *
      * @ORM\Column(name="active", type="boolean")
      */
     private $active;

     /**
      * @var string
      *
      * @ORM\Column(name="posizione", type="array", nullable=true)
      */
     private $posizione;


    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $script;

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
     * Set compagnia
     *
     * @param string compagnia
     *
     * @return Pubblicita
     */
    public function setCompagnia($compagnia)
    {
        $this->compagnia = $compagnia;

        return $this;
    }

    /**
     * Get compagnia
     *
     * @return string
     */
    public function getCompagnia()
    {
        return $this->compagnia;
    }


    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Pubblicita
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set posizione
     *
     * @param array $posizione
     *
     * @return Pubblicita
     */
    public function setPosizione($posizione)
    {
        $this->posizione = $posizione;

        return $this;
    }

    /**
     * Get posizione
     *
     * @return array
     */
    public function getPosizione()
    {
        return $this->posizione;
    }


    /**
     * Set script
     *
     * @param string script
     *
     * @return Pubblicita
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    /**
     * Get script
     *
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }



}
