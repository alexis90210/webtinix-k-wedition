<?php

namespace App\Entity;

use App\Repository\KanbanCommentaireReponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanCommentaireReponseRepository::class)
 */
class KanbanCommentaireReponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idMembre;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCommentaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reponseCommentaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMembre(): ?int
    {
        return $this->idMembre;
    }

    public function setIdMembre(int $idMembre): self
    {
        $this->idMembre = $idMembre;

        return $this;
    }

    public function getIdCommentaire(): ?int
    {
        return $this->idCommentaire;
    }

    public function setIdCommentaire(int $idCommentaire): self
    {
        $this->idCommentaire = $idCommentaire;

        return $this;
    }

    public function getIdChapitre(): ?int
    {
        return $this->idChapitre;
    }

    public function setIdChapitre(int $idChapitre): self
    {
        $this->idChapitre = $idChapitre;

        return $this;
    }

    public function getReponseCommentaire(): ?string
    {
        return $this->reponseCommentaire;
    }

    public function setReponseCommentaire(string $reponseCommentaire): self
    {
        $this->reponseCommentaire = $reponseCommentaire;

        return $this;
    }

    public function getPostAt(): ?string
    {
        return $this->postAt;
    }

    public function setPostAt(string $postAt): self
    {
        $this->postAt = $postAt;

        return $this;
    }
}
