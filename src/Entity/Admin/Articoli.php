<?php

namespace App\Entity\Admin;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Admin\Articolicategoria;

/**
 * @ORM\Table(name="articoli__articoli")
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ArticoliRepository")
 */
class Articoli
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
     * @ORM\Column(type="string", length=4000)
     */
    private $articolo;

    /**
    * @ORM\ManyToOne(targetEntity="Articolicategoria", inversedBy="articolicategoria")
    * @ORM\JoinColumn(name="articolicategoriai_id", referencedColumnName="id", onDelete="SET NULL")
    */
    private $categoria;


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string nome
     *
     * @return Articoli
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
    * @return Articoli
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
     * Set articolo
     *
     * @param string articolo
     *
     * @return Articoli
     */
    public function setArticolo($articolo)
    {
        $this->articolo = $articolo;

        return $this;
    }

    /**
     * Get articolo
     *
     * @return string
     */
    public function getArticolo()
    {
        return $this->articolo;
    }

    /**
    * Set Categoria
    *
    * @param Articolicategoria $categoria
    *
    * @return Articoli
    */
    public function setCategoria(Articolicategoria $categoria = null)
    {
     $this->categoria = $categoria;

    return $this;
    }

    /**
    * Get Categoria
    *
    * @return mixed
    */
    public function getCategoria()
    {
    return $this->categoria;
    }

}
