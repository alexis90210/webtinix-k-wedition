<?php

namespace App\Entity;

use App\Repository\KanbanSubscriberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KanbanSubscriberRepository::class)
 */
class KanbanSubscriber
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Unsubscribe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUnsubscribe(): ?string
    {
        return $this->Unsubscribe;
    }

    public function setUnsubscribe(string $Unsubscribe): self
    {
        $this->Unsubscribe = $Unsubscribe;

        return $this;
    }
}
