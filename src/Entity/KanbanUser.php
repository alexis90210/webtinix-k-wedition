<?php

namespace App\Entity;

use App\Repository\WebtinixKanbanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WebtinixKanbanRepository::class)
 */
class KanbanUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     *
     * @ORM\Column(type="string", length=255)
     */
    private $verifieEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $admin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MembreBanni;

    private $ConfirmezPassword;

    public function __construct()
    {
        $this->dateInscription = date('j/F/y');
        $this->verifieEmail = '0';
        $this->token = md5($this->dateInscription).md5($this->email);
    }

    public function getConfirmezPassword(): ?string
    {
        return $this->ConfirmezPassword;
    }

    public function setConfirmezPassword(string $ConfirmezPassword): self
    {
        $this->ConfirmezPassword = $ConfirmezPassword;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateInscription(): ?string
    {
        return $this->dateInscription;
    }

    public function setDateInscription(string $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getVerifieEmail(): ?string
    {
        return $this->verifieEmail;
    }

    public function setVerifieEmail(string $verifieEmail): self
    {
        $this->verifieEmail = $verifieEmail;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAdmin(): ?string
    {
        return $this->admin;
    }

    public function setAdmin(string $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getMembreBanni(): ?string
    {
        return $this->MembreBanni;
    }

    public function setMembreBanni(string $MembreBanni): self
    {
        $this->MembreBanni = $MembreBanni;

        return $this;
    }
}
