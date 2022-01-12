<?php

namespace App\Entity;

use App\Repository\KanbanMangaGenreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanMangaGenreRepository::class)
 */
class KanbanMangaGenre
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
    private $GenreManga;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGenre(): ?int
    {
        return $this->idGenre;
    }

    public function setIdGenre(int $idGenre): self
    {
        $this->idGenre = $idGenre;

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

    public function getGenreManga(): ?string
    {
        return $this->GenreManga;
    }

    public function setGenreManga(string $GenreManga): self
    {
        $this->GenreManga = $GenreManga;

        return $this;
    }
}
