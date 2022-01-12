<?php

namespace App\Entity;

use App\Repository\SortieChapitreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortieChapitreRepository::class)
 */
class SortieChapitre
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
     * @ORM\Column(type="string", length=255)
     */
    private $SortieChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateSortieChapitre;

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

    public function getSortieChapitre(): ?string
    {
        return $this->SortieChapitre;
    }

    public function setSortieChapitre(string $SortieChapitre): self
    {
        $this->SortieChapitre = $SortieChapitre;

        return $this;
    }

    public function getDateSortieChapitre(): ?string
    {
        return $this->dateSortieChapitre;
    }

    public function setDateSortieChapitre(string $dateSortieChapitre): self
    {
        $this->dateSortieChapitre = $dateSortieChapitre;

        return $this;
    }
}
