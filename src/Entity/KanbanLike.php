<?php

namespace App\Entity;

use App\Repository\KanbanLikeSystemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanLikeSystemRepository::class)
 */
class KanbanLike
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
    private $memberId;

    /**
     * @ORM\Column(type="integer")
     */
    private $MangaId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $IdChapitre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LikeChapitre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMemberId(): ?int
    {
        return $this->memberId;
    }

    public function setMemberId(int $memberId): self
    {
        $this->memberId = $memberId;

        return $this;
    }

    public function getMangaId(): ?int
    {
        return $this->MangaId;
    }

    public function setMangaId(int $MangaId): self
    {
        $this->MangaId = $MangaId;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getLikeChapitre(): ?string
    {
        return $this->LikeChapitre;
    }

    public function setLikeChapitre(string $LikeChapitre): self
    {
        $this->LikeChapitre = $LikeChapitre;

        return $this;
    }
}
