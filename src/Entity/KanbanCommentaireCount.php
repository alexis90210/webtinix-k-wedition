<?php

namespace App\Entity;

use App\Repository\KanbanCommentaireCountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanCommentaireCountRepository::class)
 */
class KanbanCommentaireCount
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
    private $idManga;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NbreCommentaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdManga(): ?int
    {
        return $this->idManga;
    }

    public function setIdManga(int $idManga): self
    {
        $this->idManga = $idManga;

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

    public function getNbreCommentaire(): ?string
    {
        return $this->NbreCommentaire;
    }

    public function setNbreCommentaire(string $NbreCommentaire): self
    {
        $this->NbreCommentaire = $NbreCommentaire;

        return $this;
    }
}
