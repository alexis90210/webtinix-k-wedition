<?php

namespace App\Entity;

use App\Repository\KanbanScanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanScanRepository::class)
 */
class KanbanScan
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
     * @ORM\Column(type="string", length=255)
     */
    private $ScanImages;

    /**
     * @ORM\Column(type="integer")
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

    public function getListScan(): ?array
    {
        return $this->listScan;
    }

    public function setListScan(?array $listScan): self
    {
        $this->listScan = $listScan;

        return $this;
    }

    public function getScanImages(): ?string
    {
        return $this->ScanImages;
    }

    public function setScanImages(string $ScanImages): self
    {
        $this->ScanImages = $ScanImages;

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
}
