<?php

namespace App\Entity;

use App\Repository\AdminActionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminActionsRepository::class)
 */
class AdminActions
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dateAction;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateAction(): ?string
    {
        return $this->dateAction;
    }

    public function setDateAction(string $dateAction): self
    {
        $this->dateAction = $dateAction;

        return $this;
    }
}
