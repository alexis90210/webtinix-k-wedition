<?php

namespace App\Entity;

use App\Repository\KanbanMangaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanMangaRepository::class)
 */
class KanbanManga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idManga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titreManga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MangaPostAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statusManga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeManga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $AuteurManga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MangaCover;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $MangaProfile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $decouverte;

    public function __construct()
    {
        $this->MangaPostAt = date('j F Y - H:i:s');

    }

    public function getIdManga(): ?int
    {
        return $this->idManga;
    }

    public function getTitreManga(): ?string
    {
        return $this->titreManga;
    }

    public function setTitreManga(string $titreManga): self
    {
        $this->titreManga = $titreManga;

        return $this;
    }

    public function getNbreChapitre(): ?int
    {
        return $this->nbreChapitre;
    }

    public function setNbreChapitre(int $nbreChapitre): self
    {
        $this->nbreChapitre = $nbreChapitre;

        return $this;
    }

    public function getMedia(): ?array
    {
        return $this->media;
    }

    public function setMedia(array $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getMangaPostAt(): ?string
    {
        return $this->MangaPostAt;
    }

    public function setMangaPostAt(string $MangaPostAt): self
    {
        $this->MangaPostAt = $MangaPostAt;

        return $this;
    }

    public function getStatusManga(): ?string
    {
        return $this->statusManga;
    }

    public function setStatusManga(string $statusManga): self
    {
        $this->statusManga = $statusManga;

        return $this;
    }

    public function getTypeManga(): ?string
    {
        return $this->typeManga;
    }

    public function setTypeManga(string $typeManga): self
    {
        $this->typeManga = $typeManga;

        return $this;
    }

    public function getAuteurManga(): ?string
    {
        return $this->AuteurManga;
    }

    public function setAuteurManga(string $AuteurManga): self
    {
        $this->AuteurManga = $AuteurManga;

        return $this;
    }

    public function getMangaCover(): ?string
    {
        return $this->MangaCover;
    }

    public function setMangaCover(string $MangaCover): self
    {
        $this->MangaCover = $MangaCover;

        return $this;
    }

    public function getMangaProfile(): ?string
    {
        return $this->MangaProfile;
    }

    public function setMangaProfile(string $MangaProfile): self
    {
        $this->MangaProfile = $MangaProfile;

        return $this;
    }

    public function getDecouverte(): ?bool
    {
        return $this->decouverte;
    }

    public function setDecouverte(bool $decouverte): self
    {
        $this->decouverte = $decouverte;

        return $this;
    }
}
