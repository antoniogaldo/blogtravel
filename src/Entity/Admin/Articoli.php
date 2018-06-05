<?php

namespace App\Entity\Admin;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Admin\Articolicategoria;

/**
 * @ORM\Table(name="articoli__articoli")
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ArticoliRepository")
 * @ORM\HasLifecycleCallbacks
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
    private $titolo;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="array", nullable=true)
     */
    private $tags;

    /**
      * @var boolean
      *
      * @ORM\Column(name="active", type="boolean")
      */
     private $active;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=4000)
     */
    private $articolo;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $autore;

    /**
    * @ORM\ManyToOne(targetEntity="Articolicategoria", inversedBy="articolicategoria")
    * @ORM\JoinColumn(name="articolicategoriai_id", referencedColumnName="id", onDelete="SET NULL")
    */
    private $categoria;

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
     * Set titolo
     *
     * @param string titolo
     *
     * @return Articoli
     */
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;

        return $this;
    }

    /**
     * Get titolo
     *
     * @return string
     */
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * Set autore
     *
     * @param string autore
     *
     * @return Articoli
     */
    public function setAutore($autore)
    {
        $this->autore = $autore;

        return $this;
    }

    /**
     * Get autore
     *
     * @return string
     */
    public function getAutore()
    {
        return $this->autore;
    }

    /**
     * Set image
     *
     * @param string image
     *
     * @return Articoli
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
     * Set tags
     *
     * @param array $tags
     *
     * @return Articoli
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return MareInternal
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

    /**
     * @ORM\PreRemove
     */
    public function removeUpload()
    {
      $image = $this->getImage();
        if(file_exists($image)) {
            if ($image = $this->getAbsolutePath()) {
                unlink($image);
            }
        }
    }

}
