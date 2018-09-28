<?php

namespace App\Entity\Security;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user__user")
 * @ORM\Entity(repositoryClass="App\Repository\Security\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
      * @var boolean
      *
      * @ORM\Column(name="accetto", type="boolean")
      */
     private $accetto;

    /**
     * @ORM\OneToMany(targetEntity="Commenti", mappedBy="commenti", cascade={"persist", "remove"})
     */
     private $articolilike_id;

    public function __construct()
    {
         $this->isActive = true;
    }

    public function getId()
    {
        return $this->id;
    }

    // other properties and methods

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        return $roles;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Set accetto
     *
     * @param boolean $accetto
     *
     * @return User
     */
    public function setAccetto($accetto)
    {
        $this->accetto = $accetto;
        return $this;
    }
    /**
     * Get accetto
     *
     * @return boolean
     */
    public function getAccetto()
    {
        return $this->accetto;
    }

    /**
     * Set isActive
     *
     * @param string isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }
    /**
     * Get isActive
     *
     * @return string
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
