<?php

namespace App\Entity;

use App\Repository\KanbanChapitreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanChapitreRepository::class)
 */
class KanbanChapitre
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
    private $TitreChapitre;

    /**
     * @ORM\Column(type="integer")
     */
    private $idManga;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumeroChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DateSortieChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $StatusChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateFinChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreChapitre(): ?string
    {
        return $this->TitreChapitre;
    }

    public function setTitreChapitre(string $TitreChapitre): self
    {
        $this->TitreChapitre = $TitreChapitre;

        return $this;
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

    public function getNumeroChapitre(): ?int
    {
        return $this->NumeroChapitre;
    }

    public function setNumeroChapitre(int $NumeroChapitre): self
    {
        $this->NumeroChapitre = $NumeroChapitre;

        return $this;
    }

    public function getDateSortieChapitre(): ?string
    {
        return $this->DateSortieChapitre;
    }

    public function setDateSortieChapitre(string $DateSortieChapitre): self
    {
        $this->DateSortieChapitre = $DateSortieChapitre;

        return $this;
    }

    public function getStatusChapitre(): ?string
    {
        return $this->StatusChapitre;
    }

    public function setStatusChapitre(string $StatusChapitre): self
    {
        $this->StatusChapitre = $StatusChapitre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateFinChapitre(): ?string
    {
        return $this->dateFinChapitre;
    }

    public function setDateFinChapitre(string $dateFinChapitre): self
    {
        $this->dateFinChapitre = $dateFinChapitre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
