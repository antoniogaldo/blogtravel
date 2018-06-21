<?php

namespace App\Entity\Admin;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Admin\Articoli;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="articoli__categoria")
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ArticolicategoriaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Articolicategoria
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nome;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
    * @var boolean
    *
    * @ORM\Column(name="active", type="boolean")
    */
    private $active;

    /**
    * @ORM\OneToMany(targetEntity="Articoli", mappedBy="categoria", cascade={"persist", "remove"})
    */
    private $articolicategoria;

    public function getId()
    {
        return $this->id;
    }
    public function __construct() {
        $this->articolicategoria = new ArrayCollection();
    }

    /**
     * Set nome
     *
     * @param string nome
     *
     * @return Articolicategoria
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
    * Set Data
    *
    * @param \DateTime $data
    *
    * @return Articolicategoria
    */
    public function setData($data)
    {
     $this->data = $data;

    return $this;
    }

    /**
    * Get Data
    *
    * @return \DateTime
    */
    public function getData()
    {
    return $this->data;
    }

    /**
    * Set Articolicategoria
    *
    * @param mixed $articolicategoria
    *
    * @return Articolicategoria
    */
    public function setArticolicategoria($articolicategoria)
    {
     $this->articolicategoria = $articolicategoria;

    return $this;
    }

    /**
    * Get Articolicategoria
    *
    * @return mixed
    */
    public function getArticolicategoria()
    {
    return $this->articolicategoria;
    }

    /**
     * Set image
     *
     * @param string image
     *
     * @return Articolicategoria
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Articolicategoria
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


}
