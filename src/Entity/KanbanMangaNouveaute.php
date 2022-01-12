<?php

namespace App\Entity;

use App\Repository\KanbanMangaNouveauteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanMangaNouveauteRepository::class)
 */
class KanbanMangaNouveaute
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
    private $dernierChapitre;

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

    public function getDernierChapitre(): ?string
    {
        return $this->dernierChapitre;
    }

    public function setDernierChapitre(string $dernierChapitre): self
    {
        $this->dernierChapitre = $dernierChapitre;

        return $this;
    }
}
