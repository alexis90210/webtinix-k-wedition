<?php

namespace App\Entity;

use App\Repository\CarouselRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarouselRepository::class)
 */
class Carousel
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
    private $idScan;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdScan(): ?int
    {
        return $this->idScan;
    }

    public function setIdScan(int $idScan): self
    {
        $this->idScan = $idScan;

        return $this;
    }
}
