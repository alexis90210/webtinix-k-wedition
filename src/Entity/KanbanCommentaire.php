<?php

namespace App\Entity;

use App\Repository\KanbanCommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanCommentaireRepository::class)
 */
class KanbanCommentaire
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
    private $membreId;

    /**
     * @ORM\Column(type="integer")
     */
    private $mangaId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $posteAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $SupprimeCommentaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $IdChapitre;

    public function __construct()
    {
        $this->posteAt = date('j F Y - H:i:s');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembreId(): ?int
    {
        return $this->membreId;
    }

    public function setMembreId(int $membreId): self
    {
        $this->membreId = $membreId;

        return $this;
    }

    public function getMangaId(): ?int
    {
        return $this->mangaId;
    }

    public function setMangaId(int $mangaId): self
    {
        $this->mangaId = $mangaId;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPosteAt(): ?string
    {
        return $this->posteAt;
    }

    public function setPosteAt(string $posteAt): self
    {
        $this->posteAt = $posteAt;

        return $this;
    }

    public function getSupprimeCommentaire(): ?string
    {
        return $this->SupprimeCommentaire;
    }

    public function setSupprimeCommentaire(string $SupprimeCommentaire): self
    {
        $this->SupprimeCommentaire = $SupprimeCommentaire;

        return $this;
    }

    public function getIdChapitre(): ?int
    {
        return $this->IdChapitre;
    }

    public function setIdChapitre(int $IdChapitre): self
    {
        $this->IdChapitre = $IdChapitre;

        return $this;
    }
}
