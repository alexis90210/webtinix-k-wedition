<?php

namespace App\Entity;

use App\Repository\KanbanPlanningRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanPlanningRepository::class)
 */
class KanbanPlanning
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
    private $idChapitre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $progresChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idManga;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProgresChapitre(): ?string
    {
        return $this->progresChapitre;
    }

    public function setProgresChapitre(?string $progresChapitre): self
    {
        $this->progresChapitre = $progresChapitre;

        return $this;
    }

    public function getIdManga(): ?string
    {
        return $this->idManga;
    }

    public function setIdManga(string $idManga): self
    {
        $this->idManga = $idManga;

        return $this;
    }
}
